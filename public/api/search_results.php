<?php
// Set header to return JSON
header('Content-Type: application/json');

// Start session to retrieve search parameters if stored in session
session_start();

// Get pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5; // Default 5 items per page

// Get search parameters from URL or session
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Get category (could be single value or array)
if (isset($_GET['category']) && is_array($_GET['category'])) {
    $category = $_GET['category'];
    $category_operator = isset($_GET['category_operator']) ? $_GET['category_operator'] : 'OR';
} else {
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $category_operator = 'OR'; // Default
}

// Get type (could be single value or array)
if (isset($_GET['type']) && is_array($_GET['type'])) {
    $type = $_GET['type'];
    $type_operator = isset($_GET['type_operator']) ? $_GET['type_operator'] : 'OR';
} else {
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $type_operator = 'OR'; // Default
}

// Get publication (could be single value or array)
if (isset($_GET['publication']) && is_array($_GET['publication'])) {
    $publication = $_GET['publication'];
    $publication_operator = isset($_GET['publication_operator']) ? $_GET['publication_operator'] : 'OR';
} else {
    $publication = isset($_GET['publication']) ? $_GET['publication'] : '';
    $publication_operator = 'OR'; // Default
}

$issue_number = isset($_GET['issue_number']) ? $_GET['issue_number'] : '';
$content = isset($_GET['content']) ? $_GET['content'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$date_operator = isset($_GET['date_operator']) ? $_GET['date_operator'] : 'OR';

// Validate search query
if (empty($query) || strlen($query) < 2) {
    echo json_encode([
        'success' => false,
        'message' => '検索キーワードは2文字以上で入力してください。',
        'results' => [],
        'total' => 0,
        'page' => $page,
        'limit' => $limit
    ]);
    exit;
}

// Sample search results (static data for demo)
$allResults = [
    [
        'id' => 1,
        'title' => '東京観光ガイド',
        'description' => '東京の人気観光スポットや隠れた名所について詳しくご案内します。',
        'category' => '旅行',
        'type' => 'ガイド',
        'publication' => '日経新聞',
        'issue_number' => '2023-001',
        'content' => '東京は、江戸時代から続く伝統と現代の技術が融合した魅力的な都市です。スカイツリーや東京タワーなどの有名なランドマークだけでなく、下町の風情ある街並みや隠れた名店も多数あります。この記事では、東京を訪れる観光客に向けて、定番スポットから地元の人だけが知る穴場まで、様々な観光情報をご紹介します。',
        'date' => '2023-01-15',
    ],
    [
        'id' => 2,
        'title' => '日本料理の基本',
        'description' => '和食の基礎から応用まで、伝統的な日本料理の作り方をご紹介。',
        'category' => '料理',
        'type' => '記事',
        'publication' => '朝日新聞',
        'issue_number' => '2023-042',
        'content' => '日本料理は、素材の持ち味を活かし、季節感を大切にする料理です。だしの取り方から、切り方、盛り付けまで、細部にこだわることで深い味わいと美しさを表現します。本記事では、家庭でも作れる基本的な和食のレシピと技術について解説します。初心者でも理解しやすいよう、段階的に説明していきます。',
        'date' => '2023-02-20',
    ],
    [
        'id' => 3,
        'title' => '京都の古寺巡り',
        'description' => '歴史ある京都の寺院について、その歴史や見どころを詳しく解説します。',
        'category' => '旅行',
        'type' => 'ガイド',
        'publication' => '読売新聞',
        'issue_number' => '2023-075',
        'content' => '千年の都として栄えた京都には、日本の歴史と文化を今に伝える数多くの寺院があります。清水寺、金閣寺、銀閣寺といった有名な寺院から、観光客が少ない穴場の寺院まで、それぞれの歴史的背景や建築様式、庭園の特徴などを詳しく解説します。また、各寺院を訪れる際の最適な時期やアクセス方法についても紹介しています。',
        'date' => '2023-03-10',
    ],
    [
        'id' => 4,
        'title' => '現代日本の文学作品',
        'description' => '現代日本の有名な作家とその代表作についての解説と分析。',
        'category' => '文学',
        'type' => 'コラム',
        'publication' => '毎日新聞',
        'issue_number' => '2023-118',
        'content' => '村上春樹、吉本ばなな、川上未映子など、現代日本を代表する作家たちの作品を取り上げ、その文学的価値や社会的影響について考察します。それぞれの作家の文体の特徴や繰り返し登場するテーマ、また国際的な評価についても触れながら、現代日本文学の多様性と豊かさを紹介します。日本文学に興味を持つ読者にとって、新たな読書の指針となる記事です。',
        'date' => '2023-04-25',
    ],
    [
        'id' => 5,
        'title' => '伝統的な日本の庭園設計',
        'description' => '日本庭園の様式と哲学、そして自宅で取り入れる方法について。',
        'category' => '文化',
        'type' => '記事',
        'publication' => '産経新聞',
        'issue_number' => '2023-156',
        'content' => '日本庭園は単なる観賞用の空間ではなく、自然の風景を凝縮し、哲学的な要素を含んだ芸術作品です。枯山水、池泉回遊式、茶庭など、様々な様式の庭園について解説し、それぞれの特徴や象徴的な意味を紹介します。また、一般家庭でも取り入れられる日本庭園の要素や、小さなスペースでも実現できる和風ガーデニングのアイデアも提案しています。',
        'date' => '2023-05-30',
    ],
    [
        'id' => 6,
        'title' => '東京オリンピック2020の遺産',
        'description' => 'コロナ禍で開催された東京オリンピックが残した影響と今後の展望',
        'category' => 'スポーツ',
        'type' => '記事',
        'publication' => '日経新聞',
        'issue_number' => '2023-201',
        'content' => '2021年に開催された東京オリンピック・パラリンピックは、新型コロナウイルスの影響で1年延期され、無観客での開催となりました。そのような特異な環境下で行われた大会が、日本社会やスポーツ界に与えた影響を検証します。また、新設された競技施設の利活用や、オリンピック後の日本スポーツ界の発展について、関係者へのインタビューを交えながら報告します。',
        'date' => '2023-07-15',
    ],
    [
        'id' => 7,
        'title' => '日本経済の成長戦略',
        'description' => 'ポストコロナ時代の日本経済再生に向けた政策と展望',
        'category' => '経済',
        'type' => 'コラム',
        'publication' => '日経新聞',
        'issue_number' => '2023-245',
        'content' => '長期的なデフレと低成長に悩まされてきた日本経済が、コロナ危機を経て直面する新たな課題と機会について分析します。デジタルトランスフォーメーション、グリーン成長戦略、地方創生など、今後の経済成長のカギとなる政策や取り組みを紹介し、日本企業が国際競争力を高めるために必要な変革について考察します。また、人口減少社会における持続可能な経済モデルの構築についても議論します。',
        'date' => '2023-09-05',
    ],
    [
        'id' => 8,
        'title' => '日本の政治改革への道',
        'description' => '変わりゆく国際情勢の中で求められる政治システムの刷新',
        'category' => '政治',
        'type' => 'インタビュー',
        'publication' => '朝日新聞',
        'issue_number' => '2023-287',
        'content' => '国内外の複雑な課題に直面する日本の政治システムについて、改革の必要性と方向性を探ります。複数の政治学者や現役政治家へのインタビューを通じて、選挙制度改革、官僚制度の見直し、政策立案プロセスの透明化など、日本の民主主義を強化するための具体的な提案を紹介します。また、若者の政治参加を促進し、多様な声を政策に反映させるための取り組みについても考察します。',
        'date' => '2023-10-20',
    ],
    // Add more sample results to demonstrate pagination
    [
        'id' => 9,
        'title' => '日本のアニメ産業の発展',
        'description' => '世界に影響を与える日本のアニメーション産業の歴史と最新動向',
        'category' => '文化',
        'type' => 'コラム',
        'publication' => '読売新聞',
        'issue_number' => '2023-342',
        'content' => '日本のアニメーションは、世界的な文化輸出として大きな成功を収めています。手塚治虫から始まる日本アニメの歴史を振り返りながら、現代の制作技術や市場動向、そして海外での受容について分析します。最新のデジタル技術がアニメ制作にもたらした変革や、配信プラットフォームの台頭によるビジネスモデルの変化についても言及し、アニメ産業が日本経済に与える影響を考察します。',
        'date' => '2023-11-15',
    ],
    [
        'id' => 10,
        'title' => '高齢化社会における医療と介護',
        'description' => '日本の高齢化社会が直面する課題と革新的な解決策',
        'category' => '医療',
        'type' => '記事',
        'publication' => '日経新聞',
        'issue_number' => '2023-378',
        'content' => '世界でも類を見ないスピードで高齢化が進む日本社会では、医療と介護のシステムが大きな課題に直面しています。本記事では、持続可能な医療制度の構築に向けた様々な取り組みや、テクノロジーを活用した新しい介護サービス、コミュニティベースのケアモデルなどを紹介します。また、高齢者自身の社会参加を促進し、健康寿命を延ばすための予防医療の重要性についても議論します。',
        'date' => '2023-12-10',
    ],
    [
        'id' => 11,
        'title' => '日本の教育改革',
        'description' => 'グローバル時代に求められる新しい学びのかたち',
        'category' => '教育',
        'type' => 'インタビュー',
        'publication' => '朝日新聞',
        'issue_number' => '2024-012',
        'content' => '急速な技術革新とグローバル化が進む現代社会において、日本の教育システムはどのように変わるべきか。文部科学省の担当者や教育学者、先進的な取り組みを行う学校の教師たちへのインタビューを通して、創造性や批判的思考力を育む教育、ICTを活用した学習方法、多様性を重視した学校文化の構築などについて考察します。また、大学入試改革や英語教育の見直しなど、現在進行中の教育政策についても検証します。',
        'date' => '2024-01-25',
    ],
    [
        'id' => 12,
        'title' => '日本の伝統工芸の未来',
        'description' => '伝統技術とイノベーションの融合による工芸品の現代的展開',
        'category' => '文化',
        'type' => '記事',
        'publication' => '毎日新聞',
        'issue_number' => '2024-054',
        'content' => '何世紀にもわたって継承されてきた日本の伝統工芸は、職人の高齢化や需要の減少によって存続の危機に直面しています。しかし、若い世代の職人たちが伝統技術に現代的なデザインや新しい素材を取り入れることで、伝統工芸に新たな命を吹き込んでいます。本記事では、京都の西陣織、輪島塗、有田焼など各地の伝統工芸の現状と革新的な取り組みを紹介し、グローバル市場での可能性や、技術継承に向けた教育プログラムについても考察します。',
        'date' => '2024-02-20',
    ],
];

// Filter results based on all search parameters
$filteredResults = array_filter($allResults, function($result) use ($query, $category, $category_operator, $type, $type_operator, $publication, $publication_operator, $issue_number, $content, $date_from, $date_to, $date_operator) {
    // Match query against title and description
    $matchesQuery = stripos($result['title'], $query) !== false || 
                   stripos($result['description'], $query) !== false ||
                   stripos($result['content'], $query) !== false;
    
    // Match category if specified
    if (is_array($category) && !empty($category)) {
        // Handle multiple categories with AND/OR
        if ($category_operator === 'AND') {
            // With AND, result must match ALL categories
            $matchesCategory = true;
            foreach ($category as $cat) {
                if ($result['category'] !== $cat) {
                    $matchesCategory = false;
                    break;
                }
            }
        } else {
            // With OR, result must match ANY category
            $matchesCategory = false;
            foreach ($category as $cat) {
                if ($result['category'] === $cat) {
                    $matchesCategory = true;
                    break;
                }
            }
        }
    } else {
        // Handle single category
        $matchesCategory = empty($category) || $result['category'] === $category;
    }
    
    // Match type if specified
    if (is_array($type) && !empty($type)) {
        // Handle multiple types with AND/OR
        if ($type_operator === 'AND') {
            // With AND, result must match ALL types
            $matchesType = true;
            foreach ($type as $t) {
                if ($result['type'] !== $t) {
                    $matchesType = false;
                    break;
                }
            }
        } else {
            // With OR, result must match ANY type
            $matchesType = false;
            foreach ($type as $t) {
                if ($result['type'] === $t) {
                    $matchesType = true;
                    break;
                }
            }
        }
    } else {
        // Handle single type
        $matchesType = empty($type) || $result['type'] === $type;
    }
    
    // Match publication if specified
    if (is_array($publication) && !empty($publication)) {
        // Handle multiple publications with AND/OR
        if ($publication_operator === 'AND') {
            // With AND, result must match ALL publications (not typical in real use)
            $matchesPublication = true;
            foreach ($publication as $pub) {
                if ($result['publication'] !== $pub) {
                    $matchesPublication = false;
                    break;
                }
            }
        } else {
            // With OR, result must match ANY publication
            $matchesPublication = false;
            foreach ($publication as $pub) {
                if ($result['publication'] === $pub) {
                    $matchesPublication = true;
                    break;
                }
            }
        }
    } else {
        // Handle single publication
        $matchesPublication = empty($publication) || $result['publication'] === $publication;
    }
    
    // Match issue number if specified
    $matchesIssueNumber = empty($issue_number) || stripos($result['issue_number'], $issue_number) !== false;
    
    // Match content if specified
    $matchesContent = empty($content) || stripos($result['content'], $content) !== false;
    
    // Match date ranges if specified
    $matchesDateRange = true;
    
    if (!empty($date_from) && is_array($date_from) && !empty($date_to) && is_array($date_to)) {
        // Handle multiple date ranges with AND/OR
        $matchesRanges = array();
        
        for ($i = 0; $i < count($date_from); $i++) {
            $from = isset($date_from[$i]) ? $date_from[$i] : null;
            $to = isset($date_to[$i]) ? $date_to[$i] : null;
            
            $matchesFromInRange = empty($from) || $result['date'] >= $from;
            $matchesToInRange = empty($to) || $result['date'] <= $to;
            
            // Result matches if it's within this particular range
            $matchesRanges[] = $matchesFromInRange && $matchesToInRange;
        }
        
        if ($date_operator === 'AND') {
            // With AND, result must be in ALL date ranges
            $matchesDateRange = !in_array(false, $matchesRanges);
        } else {
            // With OR, result must be in ANY date range
            $matchesDateRange = in_array(true, $matchesRanges);
        }
    } else {
        // Handle single date range for backwards compatibility
        $matchesDateFrom = empty($date_from) || $result['date'] >= $date_from;
        $matchesDateTo = empty($date_to) || $result['date'] <= $date_to;
        $matchesDateRange = $matchesDateFrom && $matchesDateTo;
    }
    
    // Return true only if all specified conditions match
    return $matchesQuery && $matchesCategory && $matchesType && $matchesPublication && 
           $matchesIssueNumber && $matchesContent && $matchesDateRange;
});

// Keep original keys
$filteredResults = array_values($filteredResults);

// Calculate total results and pagination
$total = count($filteredResults);
$totalPages = ceil($total / $limit);

// Validate page number
if ($page < 1) $page = 1;
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;

// Calculate offset
$offset = ($page - 1) * $limit;

// Get paginated results
$paginatedResults = array_slice($filteredResults, $offset, $limit);

// Prepare response data
$response = [
    'success' => true,
    'results' => $paginatedResults,
    'total' => $total,
    'page' => $page,
    'limit' => $limit,
    'totalPages' => $totalPages,
    'hasMore' => $page < $totalPages
];

// Return JSON response
echo json_encode($response);
exit;