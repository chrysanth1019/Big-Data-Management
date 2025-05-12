<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Schema;

class SimpleSearchController extends Controller
{
    /**
     * Display the search page with results if search parameters are provided.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = category::orderBy("id")->get();
        
        if (!$request->anyFilled(['query', 'category', 'date_from', 'date_to'])) {
            return view('frontend.search.simple-search', [
                'categories' => $categories
            ]);
        }


        $rawQuery = $request->input('query');
        $unions = [];
        $pattern = '/\s+(AND|OR)\s+/i';
        $parts = preg_split($pattern, $rawQuery, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $terms = [];
        $logic = [];
        foreach ($parts as $part) {
            $trimmed = trim($part);
            if (preg_match('/^(AND|OR)$/i', $trimmed)) {
                $logic[] = strtoupper($trimmed);
            } else {
                $terms[] = $trimmed;
            }
        }

        $from = Carbon::parse($request->input('date_from'));
        $to = Carbon::parse($request->input('date_to'));

        $period = CarbonPeriod::create($from->startOfMonth(), '1 month', $to->startOfMonth());

        foreach ($period as $date) {
            $table = sprintf('data_%d_%02d', $date->year, $date->month);
            if (!Schema::hasTable($table)) continue;

            $query = DB::table($table)->select('id', 'category', 'type_id', 'publication_id', 'issue', 'content', 'year', 'month', 'day');

            $query->where(function ($outer) use ($terms, $logic, $request, $from, $to) {
                $outer->where(function ($q) use ($terms, $logic) {
                    if (empty($terms)) return;

                    $q->whereRaw('`content` LIKE "%' . array_shift($terms) . '%"');

                    foreach ($terms as $index => $term) {
                        $operator = $logic[$index] ?? 'AND';
                        if ($operator === 'OR') {
                            $q->orWhereRaw('`content` LIKE "%' . $term . '%"');
                        } else {
                            $q->whereRaw('`content` LIKE "%' . $term . '%"');
                        }
                    }
                });

                if ($request->filled('category')) {
                    $cat = $request->input('category');
                    if ($cat != 0) {
                        $outer->whereRaw(DB::raw("category = $cat"));
                    }
                }
                // for whole search
                // $outer->whereRaw("`date` >= '$from'")
                //     ->whereRaw("`date` <= '$to'");

            });

            $unions[] = $query;
        }

        $finalQuery = array_shift($unions);
        foreach ($unions as $q) {
            $finalQuery->unionAll($q);
        }

        $perPage = $request->input('per_page', 50);
        $page = $request->input('page', 1);
        $validPerPageOptions = [50, 100, 200];
        if (!in_array($perPage, $validPerPageOptions)) {
            $perPage = 50;
        }
        if (empty($finalQuery)) {
             $results = new LengthAwarePaginator(
                [],
                0,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        else {
            $tbl = $finalQuery->toSql();
            $subQ = DB::table(DB::raw("($tbl) AS `q`"))
                ->select([
                    "q.id AS id", 
                    "q.category as category",
                     "q.type_id as type_id",
                     "q.publication_id as publication_id",
                    "q.issue AS issue",
                    "q.content AS content",
                    DB::raw("STR_TO_DATE(CONCAT(`q`.`year`, '-', `q`.`month`, '-', `q`.`day`), '%Y-%m-%d') AS `date`")
                ]);
            
            $query = $subQ->toSql();
            $bindings = $subQ->getBindings();
            $fullQuery = $query;
            foreach ($bindings as $binding) {
                $fullQuery = preg_replace('/\?/', "'$binding'", $fullQuery, 1);
            }
            $query = DB::table(DB::raw("({$fullQuery}) as q"))
                ->orderBy("date");

            $totalCnt = $query->count();
            
            $query = DB::table(DB::raw("({$query->toSql()}) as q"))
                ->leftJoin("categories", "categories.id", "=", "q.category")
                ->leftJoin("types", "types.id", "=", "q.type_id")
                ->leftJoin("publications", "publications.id", "=", "q.publication_id")
                ->select([
                    "q.id AS id", 
                    "categories.alias as category", 
                    "types.alias as type",
                    "publications.alias as publication", 
                    "q.publication_id as publication",
                    "q.issue AS issue",
                    "q.content AS content",
                    "q.date AS date"
                ]);
            
            $items = $query->offset(($page - 1) * $perPage)
                ->limit($perPage)
                ->get();
    
            $results = new LengthAwarePaginator(
                $items,
                $totalCnt,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
        }
        
        return view('frontend.search.simple-search', [
            'results' => $results,
            'categories' => $categories,
            'pageOptions' => $validPerPageOptions
        ]);
    }
    
    /**
     * Filter results based on search criteria.
     *
     * @param  array  $results
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function filterResults($results, $request)
    {
        // Filter by keyword/query if provided
        if ($request->filled('query')) {
            $query = strtolower($request->input('query'));
            $results = array_filter($results, function($item) use ($query) {
                return strpos(strtolower($item['title']), $query) !== false || 
                       strpos(strtolower($item['excerpt']), $query) !== false;
            });
        }
        
        // Filter by category if selected
        if ($request->filled('category')) {
            $results = array_filter($results, function($item) use ($request) {
                return $item['category'] == $request->input('category');
            });
        }
        
        // Filter by date range if provided
        if ($request->filled('date_from')) {
            $dateFrom = strtotime($request->input('date_from'));
            $results = array_filter($results, function($item) use ($dateFrom) {
                return strtotime($item['date']) >= $dateFrom;
            });
        }
        
        if ($request->filled('date_to')) {
            $dateTo = strtotime($request->input('date_to'));
            $results = array_filter($results, function($item) use ($dateTo) {
                return strtotime($item['date']) <= $dateTo;
            });
        }
        
        // Ensure we return an array with sequential numeric keys
        return array_values($results);
    }
    
    /**
     * Create a paginator instance for the results.
     *
     * @param  array  $items
     * @param  int  $perPage
     * @param  int  $page
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function paginateResults($items, $perPage, $page, $request)
    {
        // Get the slice of items for the current page
        $offset = ($page - 1) * $perPage;
        $itemsForCurrentPage = array_slice($items, $offset, $perPage);
        
        // Create a paginator instance
        $paginator = new LengthAwarePaginator(
            $itemsForCurrentPage,
            count($items),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return $paginator;
    }
    
    /**
     * Generate sample results for demonstration purposes.
     * In a real application, this would retrieve data from a database.
     *
     * @return array
     */
    private function getSampleResults()
    {
        $categories = ['technology', 'environment', 'healthcare', 'finance', 'legal'];
        $types = ['report', 'paper', 'study', 'analysis', 'article'];
        $publishers = ['企業', '政府機関', '大学・研究機関', '非営利団体', '独立研究者'];
        
        // Base results with fixed data for consistency
        $results = [
            [
                'id' => 1,
                'title' => '2024年度 テクノロジー業界の動向分析',
                'category' => 'technology',
                'type' => 'report',
                'publisher' => '企業',
                'date' => '2024-03-15',
                'excerpt' => 'AIと機械学習技術の発展により、多くの産業でデジタルトランスフォーメーションが加速しています。本レポートでは、最新のテクノロジートレンドと市場予測を詳細に分析します。',
            ],
            [
                'id' => 2,
                'title' => 'スマートシティ構想の実装事例と評価',
                'category' => 'technology',
                'type' => 'study',
                'publisher' => '政府機関',
                'date' => '2023-09-18',
                'excerpt' => '国内外のスマートシティプロジェクトの実装事例を調査し、都市機能の効率化や市民生活の質の向上などの観点から評価しています。',
            ],
            [
                'id' => 3,
                'title' => '持続可能な環境政策の研究',
                'category' => 'environment',
                'type' => 'paper',
                'publisher' => '大学・研究機関',
                'date' => '2023-11-08',
                'excerpt' => '気候変動対策と経済発展を両立させるための政策フレームワークを提案します。先進国と発展途上国の協力モデルに焦点を当てています。',
            ],
            [
                'id' => 4,
                'title' => '再生可能エネルギー普及に向けた税制優遇措置',
                'category' => 'environment',
                'type' => 'report',
                'publisher' => '政府機関',
                'date' => '2024-01-05',
                'excerpt' => '太陽光、風力、地熱などの再生可能エネルギー普及を促進するための税制優遇措置の効果と課題について検証しています。',
            ],
            [
                'id' => 5,
                'title' => '国民健康保険制度の改革に関する分析',
                'category' => 'healthcare',
                'type' => 'analysis',
                'publisher' => '政府機関',
                'date' => '2024-01-22',
                'excerpt' => '少子高齢化社会における持続可能な健康保険制度のあり方について、国内外の事例を比較しながら分析しています。',
            ],
            [
                'id' => 6,
                'title' => 'デジタル時代の金融リテラシー教育',
                'category' => 'finance',
                'type' => 'study',
                'publisher' => '非営利団体',
                'date' => '2024-02-10',
                'excerpt' => 'オンラインバンキングやデジタル投資の普及に伴い、必要とされる金融リテラシーの変化と効果的な教育方法について調査しています。',
            ],
        ];
        
        // Technology category articles
        $techTitles = [
            'AI活用による業務効率化の実証研究',
            'クラウドコンピューティングのセキュリティ最適化',
            'ブロックチェーン技術の応用事例と課題',
            '5G通信技術の産業への影響分析',
            'サイバーセキュリティ脅威の最新動向',
            'IoTデバイスの家庭内普及と生活変化',
            'クラウドネイティブアプリケーション開発手法',
            'エッジコンピューティングの実用化と課題',
            'ビッグデータ分析による意思決定支援',
            'AI倫理とバイアス問題への対応',
            'デジタルツイン技術の産業応用',
            'オープンソースソフトウェアの企業活用戦略',
            'マイクロサービスアーキテクチャの導入効果',
            'テクノロジー業界の多様性と包括性',
            'AR/VR技術のビジネス活用事例'
        ];
        
        // Environment category articles
        $envTitles = [
            '都市部の大気汚染対策の効果測定',
            '森林資源の持続可能な管理方法',
            '海洋プラスチック汚染の削減戦略',
            '気候変動に対する都市インフラの適応策',
            '生物多様性保全のための国際協力',
            '循環型経済の実現に向けた政策提言',
            '再生可能エネルギーの地域導入モデル',
            '持続可能な農業実践の経済的効果',
            '気候変動の社会的影響と適応策',
            '廃棄物削減のための行動経済学的アプローチ',
            'カーボンニュートラル達成への道筋',
            '生態系サービスの経済的価値評価',
            '水資源管理の効率化と保全',
            '環境教育の長期的効果に関する研究',
            'グリーンビルディング認証の市場価値'
        ];
        
        // Healthcare category articles
        $healthTitles = [
            '予防医療の費用対効果分析',
            'デジタルヘルスケアの普及と課題',
            '高齢者向け在宅医療サービスの評価',
            '感染症対策の国際比較研究',
            '医療AIの診断精度と臨床応用',
            '地域医療連携システムの効果検証',
            '精神健康対策の職場導入効果',
            '遠隔医療の普及による医療アクセス改善',
            '慢性疾患管理プログラムの効果測定',
            '医療データ共有の倫理的課題',
            '患者中心の医療提供体制の構築',
            '医療従事者の働き方改革と質の維持',
            '健康増進プログラムの行動変容効果',
            '医療品質指標の国際比較',
            '緊急医療体制の最適化モデル'
        ];
        
        // Finance category articles
        $financeTitles = [
            'フィンテックによる中小企業融資の変革',
            'ESG投資の長期的パフォーマンス分析',
            'デジタル通貨の金融システムへの影響',
            '退職金制度の国際比較研究',
            'リスク管理手法の最新動向',
            '金融包摂に向けたテクノロジー活用',
            '持続可能な金融商品の市場動向',
            '資産運用の自動化と個人化',
            'クラウドファンディングの社会的インパクト',
            'インフレーション対策と資産保全戦略',
            '金融リテラシーと経済的意思決定',
            '年金制度改革のシミュレーション分析',
            '保険テクノロジーの革新と課題',
            '企業価値評価モデルの比較研究',
            '規制変更の金融市場への影響'
        ];
        
        // Legal category articles
        $legalTitles = [
            'データプライバシー法制の国際比較',
            '人工知能と法的責任の考察',
            '国際取引における契約法の調和',
            '知的財産権保護の新たな枠組み',
            'インターネット上の表現の自由と規制',
            'デジタル環境での消費者保護法制',
            '法的サービスのアクセシビリティ向上策',
            '環境法の国際的発展と国内実装',
            '司法制度のデジタル化と効率化',
            '企業コンプライアンスの最適実践',
            '労働法の現代的課題と対応',
            '国際人権法の国内適用メカニズム',
            '租税法の国際的調和と課題',
            '自律型システムの法的フレームワーク',
            '金融規制の効果と影響の評価'
        ];
        
        $categoryTitles = [
            'technology' => $techTitles,
            'environment' => $envTitles,
            'healthcare' => $healthTitles,
            'finance' => $financeTitles,
            'legal' => $legalTitles
        ];
        
        $excerpts = [
            'technology' => '最新のテクノロジー動向を分析し、その活用方法と課題について考察しています。ビジネスへの実装事例も含め、具体的な成功要因を検証します。',
            'environment' => '環境問題の現状分析と持続可能な解決策を提示します。国内外の先進的な取り組みを参考に、実行可能な対策を検討しています。',
            'healthcare' => '医療・健康分野における課題と革新的解決策について論じています。医療の質向上とアクセス改善のための提言を行っています。',
            'finance' => '金融市場の構造的変化と新たな投資機会について分析しています。リスク管理と収益最大化の観点から戦略的アプローチを提案します。',
            'legal' => '法的枠組みの最新動向と社会的影響について考察しています。法制度の国際比較を通じて、最適な法的アプローチを検討します。'
        ];
        
        // Add 60 more items (12 for each category) for a total of 66 items
        $id = 7;
        foreach ($categories as $category) {
            $titles = $categoryTitles[$category];
            $excerpt = $excerpts[$category];
            
            for ($i = 0; $i < 12; $i++) {
                $year = rand(2022, 2024);
                $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
                $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
                $date = "{$year}-{$month}-{$day}";
                
                $titleIndex = $i % count($titles);
                $publisherIndex = rand(0, count($publishers) - 1);
                $typeIndex = rand(0, count($types) - 1);
                
                $results[] = [
                    'id' => $id++,
                    'title' => $titles[$titleIndex],
                    'category' => $category,
                    'type' => $types[$typeIndex],
                    'publisher' => $publishers[$publisherIndex],
                    'date' => $date,
                    'excerpt' => $excerpt,
                ];
            }
        }
        return $results;
    }

    public function myip(Request $request) {
        $ip = $request->ip();

        $response = Http::get("https://ipinfo.io/widget/demo/{$ip}");
        $result = [
                "ip" => $ip,
                "city" => "",
                "region" => "",
                "country" => "",
                "loc" => "",
                "org" => "",
                "postal" => "",
                "timezone" => "",
            ];
        if ($response->header('Content-Type') === 'application/json') {
            $json = $response->json();
            if ($json != null && array_key_exists('data', $json)) {
                $data = $json['data'];
                $result = [
                    "ip" => $ip,
                    "city" => $data['city'],
                    "region" => $data['region'],
                    "country" => $data['country'],
                    "loc" => $data['loc'],
                    "org" => $data['org'],
                    "postal" => $data['postal'],
                    "timezone" => $data['timezone'],
                ];
            }
        }
        return view('myip', $result);
    }
}