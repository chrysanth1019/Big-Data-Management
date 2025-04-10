<?php
// Get search parameters from URL
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

// Set up pagination variables
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 5;

// Validate search query
if (empty($query) || strlen($query) < 2) {
    $redirect_url = strpos($_SERVER['HTTP_REFERER'], 'advanced_search.php') !== false ? 
        'advanced_search.php' : 'search.php';
    header("Location: $redirect_url?error=検索キーワードは2文字以上で入力してください。");
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
    [
        'id' => 9,
        'title' => '日本のAI技術最前線',
        'description' => '人工知能技術における日本の取り組みと世界での立ち位置',
        'category' => '技術',
        'type' => '記事',
        'publication' => '日経新聞',
        'issue_number' => '2023-324',
        'content' => '急速に発展する人工知能（AI）技術において、日本の研究機関や企業がどのような取り組みを行っているかを紹介します。自然言語処理、画像認識、ロボティクスなど、各分野での最新の研究成果や実用化例を取り上げ、日本のAI技術の強みと課題を分析します。また、AI倫理や社会実装における日本独自のアプローチについても考察し、今後の発展の方向性を展望します。',
        'date' => '2023-11-20',
    ],
    [
        'id' => 10,
        'title' => '日本の伝統工芸の未来',
        'description' => '現代社会における伝統工芸の価値再発見と継承の取り組み',
        'category' => '文化',
        'type' => 'レポート',
        'publication' => '朝日新聞',
        'issue_number' => '2023-356',
        'content' => '何世紀にもわたって受け継がれてきた日本の伝統工芸が、現代社会でどのように変化し、新たな価値を生み出しているかを探ります。若手職人の革新的な取り組みや、伝統技術と現代デザインの融合、海外市場への展開など、伝統工芸の新たな可能性について紹介します。また、技術継承の課題や、伝統工芸を支える政策や教育システムについても考察し、未来への展望を示します。',
        'date' => '2023-12-22',
    ],
    [
        'id' => 11,
        'title' => '持続可能な日本の農業',
        'description' => '環境保全と効率化を両立させる次世代農業の取り組み',
        'category' => '農業',
        'type' => 'レポート',
        'publication' => '読売新聞',
        'issue_number' => '2024-015',
        'content' => '気候変動や生物多様性の喪失、農業従事者の高齢化など、多くの課題に直面する日本の農業部門において、持続可能性を高めるための革新的な取り組みを紹介します。有機農業の拡大、スマート農業技術の導入、都市農業の発展など、環境負荷を減らしながら生産性を向上させる方法について解説します。また、食の安全保障や地域経済活性化の観点からも、これからの日本の農業の在り方を考察します。',
        'date' => '2024-01-15',
    ],
    [
        'id' => 12,
        'title' => '変わりゆく日本の働き方',
        'description' => 'テレワークとオフィスのハイブリッド化がもたらす新たな職場文化',
        'category' => '社会',
        'type' => 'コラム',
        'publication' => '毎日新聞',
        'issue_number' => '2024-047',
        'content' => 'コロナ禍を契機に急速に広まったテレワークが、日本の職場文化にどのような変化をもたらしているかを検証します。オフィスとリモートワークを組み合わせたハイブリッドワークの定着、ワークライフバランスの向上、働き方改革の進展など、ポジティブな側面に焦点を当てつつ、コミュニケーションの変化や評価制度の課題についても考察します。また、地方への移住や副業の増加など、働き方の多様化がもたらす社会変化についても分析します。',
        'date' => '2024-02-16',
    ],
    [
        'id' => 13,
        'title' => '日本の教育DX最前線',
        'description' => 'デジタル技術を活用した教育革新の現状と展望',
        'category' => '教育',
        'type' => '記事',
        'publication' => '日経新聞',
        'issue_number' => '2024-078',
        'content' => 'GIGAスクール構想をはじめとする教育のデジタルトランスフォーメーション（DX）の取り組みが、日本の学校教育にどのような変化をもたらしているかを紹介します。1人1台端末環境の活用事例、先進的なEdTech（教育テクノロジー）の導入、教師のICTスキル向上への取り組みなど、各地の学校で進む教育イノベーションについて解説します。また、デジタル格差の是正や情報リテラシー教育の重要性など、教育DXを進める上での課題と解決策についても考察します。',
        'date' => '2024-03-18',
    ],
    [
        'id' => 14,
        'title' => '日本の水素エネルギー戦略',
        'description' => 'カーボンニュートラルへの鍵を握る水素技術開発と普及の展望',
        'category' => 'エネルギー',
        'type' => 'レポート',
        'publication' => '産経新聞',
        'issue_number' => '2024-092',
        'content' => '2050年カーボンニュートラル達成に向けた重要な施策として位置づけられる水素エネルギーについて、日本の技術開発状況や普及戦略を詳細に解説します。燃料電池自動車や水素発電、グリーン水素の製造技術など、水素社会実現に向けた最新の取り組みを紹介するとともに、インフラ整備や国際的なサプライチェーン構築の動向について分析します。また、水素関連産業の経済効果や雇用創出の可能性についても言及し、日本のエネルギー転換の展望を示します。',
        'date' => '2024-04-01',
    ],
    [
        'id' => 15,
        'title' => '東京の都市再生計画',
        'description' => 'ポストコロナ時代の持続可能な大都市モデルを目指して',
        'category' => '都市計画',
        'type' => '記事',
        'publication' => '読売新聞',
        'issue_number' => '2024-106',
        'content' => 'コロナ禍やリモートワークの普及により、オフィス需要の変化や郊外移住の増加など、大きな転換点を迎えている東京の都市計画について解説します。都心部の再開発プロジェクト、グリーンインフラの整備、15分生活圏の構築など、より持続可能で強靭な都市への変革を目指す取り組みを紹介するとともに、少子高齢化や気候変動への対応も含めた総合的な都市戦略について分析します。また、海外の先進的な都市計画との比較や、日本の他の都市への応用可能性についても考察します。',
        'date' => '2024-04-15',
    ],
];

// Filter results based on all search parameters
$results = array_filter($allResults, function($result) use ($query, $category, $category_operator, $type, $type_operator, $publication, $publication_operator, $issue_number, $content, $date_from, $date_to) {
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
    
    // Match date range
    $matchesDateFrom = empty($date_from) || $result['date'] >= $date_from;
    $matchesDateTo = empty($date_to) || $result['date'] <= $date_to;
    $matchesDateRange = $matchesDateFrom && $matchesDateTo;
    
    // Return true only if all specified conditions match
    return $matchesQuery && $matchesCategory && $matchesType && $matchesPublication && 
           $matchesIssueNumber && $matchesContent && $matchesDateRange;
});

// Re-index the array to ensure sequential keys
$results = $allResults;//array_values($results);

// Calculate pagination details
$total_items = count($results);
$total_pages = ceil($total_items / $items_per_page);

// Ensure current page is within valid range
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
}

// Get the slice of results for the current page
$offset = ($current_page - 1) * $items_per_page;
$paginated_results = array_slice($results, $offset, $items_per_page);

// Function to build the pagination URL with all search parameters
function buildPaginationUrl($page) {
    $params = $_GET;
    $params['page'] = $page;
    return $_SERVER['PHP_SELF'] . '?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>検索結果（テーブル表示） - 日本スタイルのウェブアプリケーション</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Japanese fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Japanese-style CSS -->
    <link href="css/japanese-style.css" rel="stylesheet">
    
    <!-- Zen-like Mobile CSS -->
    <link href="css/zen-mobile.css" rel="stylesheet">
    
    <style>
        .jp-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .jp-table th {
            background-color: rgba(208, 90, 110, 0.08);
            color: #333;
            font-weight: 500;
            padding: 14px 15px;
            text-align: left;
            border-bottom: 2px solid rgba(208, 90, 110, 0.2);
            font-family: 'Noto Sans JP', sans-serif;
        }
        
        .jp-table td {
            padding: 14px 15px;
            border-bottom: 1px solid #eee;
            color: #333;
            vertical-align: middle;
        }
        
        .jp-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .jp-table tbody tr:hover {
            background-color: rgba(208, 90, 110, 0.03);
        }
        
        .jp-table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 20px;
        }
        
        .jp-table-badge {
            display: inline-block;
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: rgba(208, 90, 110, 0.1);
            color: #D05A6E;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .jp-date {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 0.85rem;
            color: #666;
            white-space: nowrap;
        }
        
        .jp-pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        
        .jp-pagination-inner {
            display: flex;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .jp-pagination-item {
            padding: 10px 15px;
            border-right: 1px solid #eee;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
            min-width: 45px;
            text-align: center;
        }
        
        .jp-pagination-item:last-child {
            border-right: none;
        }
        
        .jp-pagination-item:hover {
            background-color: rgba(208, 90, 110, 0.05);
            color: #D05A6E;
        }
        
        .jp-pagination-item.active {
            background-color: #D05A6E;
            color: #fff;
            font-weight: 500;
        }
        
        .jp-pagination-item.disabled {
            color: #aaa;
            pointer-events: none;
        }
        
        .jp-view-toggle {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .jp-view-toggle a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }
        
        .jp-view-toggle a:hover {
            background-color: rgba(208, 90, 110, 0.05);
            color: #D05A6E;
        }
        
        .jp-search-summary {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            font-family: 'Noto Sans JP', sans-serif;
        }
        
        .jp-search-term {
            font-weight: 700;
            color: #D05A6E;
        }
        
        .jp-search-count {
            background-color: rgba(208, 90, 110, 0.1);
            color: #D05A6E;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .jp-result-content {
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        @media (max-width: 767px) {
            .jp-table th, .jp-table td {
                padding: 10px;
            }
            
            .jp-table th:nth-child(3),
            .jp-table td:nth-child(3),
            .jp-table th:nth-child(4),
            .jp-table td:nth-child(4) {
                display: none;
            }
            
            .jp-result-content {
                max-width: 180px;
            }
        }
    </style>
</head>
<body>
    <header class="jp-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <span class="jp-logo">和</span>
                    <span class="jp-title">検索アプリ</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarNav" aria-controls="navbarNav" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/search.php">検索</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/upload.php">アップロード</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login.php">ログイン</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="jp-main">
        <div class="container py-4">
            <div class="jp-card">
                <div class="jp-card-header">
                    <h1 class="jp-title">検索結果（テーブル表示）</h1>
                    <div class="jp-divider">
                        <div class="jp-divider-inner"></div>
                    </div>
                    
                    <div class="jp-search-summary">
                        <div class="jp-search-term">「<?php echo htmlspecialchars($query); ?>」</div>
                        <div class="jp-search-count"><?php echo $total_items; ?> 件</div>
                        
                        <?php if (!empty($category)): ?>
                            <div>カテゴリー: <strong><?php echo is_array($category) ? implode(', ', $category) : $category; ?></strong></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($type)): ?>
                            <div>タイプ: <strong><?php echo is_array($type) ? implode(', ', $type) : $type; ?></strong></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="jp-view-toggle">
                        <a href="search_results.php?<?php echo http_build_query($_GET); ?>">
                            <i class="fas fa-th-large"></i> カード表示に切替
                        </a>
                    </div>
                </div>
                
                <div class="jp-card-body">
                    <?php if (empty($paginated_results)): ?>
                        <div class="jp-empty-results">
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h3 class="h5 mb-3">検索結果はありません</h3>
                                <p class="text-muted">検索条件を変更して、もう一度お試しください。</p>
                                <a href="/search.php" class="btn jp-btn jp-btn-outline mt-3">
                                    検索ページに戻る
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="jp-table-responsive">
                            <table class="jp-table">
                                <thead>
                                    <tr>
                                        <th>タイトル</th>
                                        <th>カテゴリー</th>
                                        <th>出版元</th>
                                        <th>タイプ</th>
                                        <th>日付</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paginated_results as $result): ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?php echo htmlspecialchars($result['title']); ?></div>
                                                <div class="jp-result-content text-muted"><?php echo htmlspecialchars($result['description']); ?></div>
                                            </td>
                                            <td>
                                                <span class="jp-table-badge"><?php echo htmlspecialchars($result['category']); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($result['publication']); ?></td>
                                            <td><?php echo htmlspecialchars($result['type']); ?></td>
                                            <td class="jp-date"><?php echo htmlspecialchars($result['date']); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm jp-btn jp-btn-outline" 
                                                    data-bs-toggle="modal" data-bs-target="#resultModal<?php echo $result['id']; ?>">
                                                    <i class="fas fa-eye"></i> 詳細
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <div class="jp-pagination">
                                <div class="jp-pagination-inner">
                                    <!-- Previous page link -->
                                    <a href="<?php echo buildPaginationUrl(max(1, $current_page - 1)); ?>" 
                                        class="jp-pagination-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    
                                    <!-- Page number links -->
                                    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                                        <a href="<?php echo buildPaginationUrl($i); ?>" 
                                            class="jp-pagination-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php endfor; ?>
                                    
                                    <!-- Next page link -->
                                    <a href="<?php echo buildPaginationUrl(min($total_pages, $current_page + 1)); ?>" 
                                        class="jp-pagination-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Result Detail Modals -->
    <?php foreach ($paginated_results as $result): ?>
        <div class="modal fade" id="resultModal<?php echo $result['id']; ?>" tabindex="-1" 
            aria-labelledby="resultModalLabel<?php echo $result['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel<?php echo $result['id']; ?>">
                            <?php echo htmlspecialchars($result['title']); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="jp-table-badge"><?php echo htmlspecialchars($result['category']); ?></span>
                            <span class="badge bg-light text-dark"><?php echo htmlspecialchars($result['type']); ?></span>
                            <span class="badge bg-light text-dark"><?php echo htmlspecialchars($result['publication']); ?></span>
                            <span class="badge bg-light text-dark"><?php echo htmlspecialchars($result['issue_number']); ?></span>
                            <span class="badge bg-light text-dark"><?php echo htmlspecialchars($result['date']); ?></span>
                        </div>
                        <p class="fw-bold"><?php echo htmlspecialchars($result['description']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($result['content'])); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn jp-btn jp-btn-outline" data-bs-dismiss="modal">閉じる</button>
                        <button type="button" class="btn jp-btn jp-btn-primary">ダウンロード</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <footer class="jp-footer text-center py-4">
        <div class="container">
            <div class="jp-footer-pattern"></div>
            <p>&copy; <?php echo date('Y'); ?> 日本スタイルのウェブアプリケーション. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Zen mode script -->
    <script src="js/zen-mode.js"></script>
</body>
</html>