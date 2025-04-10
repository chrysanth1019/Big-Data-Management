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

// Get date (could be single value or array)
if (isset($_GET['date']) && is_array($_GET['date'])) {
    $date = $_GET['date'];
    $date_operator = isset($_GET['date_operator']) ? $_GET['date_operator'] : 'OR';
} else {
    $date = isset($_GET['date']) ? $_GET['date'] : '';
    $date_operator = 'OR'; // Default
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
];

// Filter results based on all search parameters
$results = array_filter($allResults, function($result) use ($query, $category, $category_operator, $type, $type_operator, $publication, $publication_operator, $issue_number, $content, $date_from, $date_to, $date_operator) {
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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>検索結果 - 日本スタイルのウェブアプリケーション</title>
    
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
                            <a class="nav-link" href="/dashboard.php">ダッシュボード</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/search.php">検索</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login.php">ログアウト</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="jp-main">
        <div class="container py-4">
            <div class="jp-results-container">
                <div class="row">
                    <div class="col-12">
                        <div class="jp-card">
                            <div class="jp-card-header">
                                <h1 class="jp-title">検索結果</h1>
                                <div class="jp-divider">
                                    <div class="jp-divider-inner"></div>
                                </div>
                                <p class="jp-search-summary">
                                    <span class="fw-bold">「<?php echo htmlspecialchars($query); ?>」</span>の検索結果
                                </p>
                                <div class="jp-search-filters">
                                    <?php if($category): ?>
                                        <div class="jp-filter-item">
                                            <span class="jp-filter-label">カテゴリー:</span>
                                            <?php if(is_array($category)): ?>
                                                <?php foreach($category as $index => $cat): ?>
                                                    <span class="jp-category-badge"><?php echo htmlspecialchars($cat); ?></span>
                                                    <?php if($index < count($category) - 1): ?>
                                                        <span class="jp-operator-badge"><?php echo htmlspecialchars($category_operator); ?></span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="jp-category-badge"><?php echo htmlspecialchars($category); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($type): ?>
                                        <div class="jp-filter-item">
                                            <span class="jp-filter-label">種類:</span>
                                            <?php if(is_array($type)): ?>
                                                <?php foreach($type as $index => $t): ?>
                                                    <span class="jp-type-badge"><?php echo htmlspecialchars($t); ?></span>
                                                    <?php if($index < count($type) - 1): ?>
                                                        <span class="jp-operator-badge"><?php echo htmlspecialchars($type_operator); ?></span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="jp-type-badge"><?php echo htmlspecialchars($type); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($publication): ?>
                                        <div class="jp-filter-item">
                                            <span class="jp-filter-label">出版物:</span>
                                            <?php if(is_array($publication)): ?>
                                                <?php foreach($publication as $index => $pub): ?>
                                                    <span class="jp-publication-badge"><?php echo htmlspecialchars($pub); ?></span>
                                                    <?php if($index < count($publication) - 1): ?>
                                                        <span class="jp-operator-badge"><?php echo htmlspecialchars($publication_operator); ?></span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="jp-publication-badge"><?php echo htmlspecialchars($publication); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($date_from) || !empty($date_to)): ?>
                                        <div class="jp-filter-item">
                                            <span class="jp-filter-label">期間:</span>
                                            <?php if(is_array($date_from) && is_array($date_to)): ?>
                                                <!-- Multiple date ranges -->
                                                <?php for($i = 0; $i < count($date_from); $i++): ?>
                                                    <?php if(!empty($date_from[$i]) || !empty($date_to[$i])): ?>
                                                        <?php if($i > 0): ?>
                                                            <span class="jp-operator-badge"><?php echo htmlspecialchars($date_operator); ?></span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($date_from[$i])): ?>
                                                            <span class="jp-date-badge"><?php echo htmlspecialchars($date_from[$i]); ?></span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($date_from[$i]) && !empty($date_to[$i])): ?>
                                                            <span class="jp-date-separator">～</span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($date_to[$i])): ?>
                                                            <span class="jp-date-badge"><?php echo htmlspecialchars($date_to[$i]); ?></span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            <?php else: ?>
                                                <!-- Single date range (backwards compatibility) -->
                                                <?php if($date_from): ?>
                                                    <span class="jp-date-badge"><?php echo htmlspecialchars($date_from); ?></span>
                                                <?php endif; ?>
                                                
                                                <?php if($date_from && $date_to): ?>
                                                    <span class="jp-date-separator">～</span>
                                                <?php endif; ?>
                                                
                                                <?php if($date_to): ?>
                                                    <span class="jp-date-badge"><?php echo htmlspecialchars($date_to); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="jp-card-body">
                                <?php if(count($results) > 0): ?>
                                    <div class="jp-results-list" id="results-container">
                                        <!-- Initial results will be loaded here -->
                                    </div>
                                    
                                    <div class="jp-loading-indicator" id="loading-indicator" style="display: none;">
                                        <div class="jp-loading-wave">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <p>結果を読み込み中...</p>
                                    </div>
                                    
                                    <div class="jp-load-more text-center mt-4" id="load-more-container" style="display: none;">
                                        <button type="button" id="load-more-btn" class="jp-btn jp-btn-outline">
                                            もっと見る <i class="fas fa-angle-down ms-1"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Template for search results (hidden) -->
                                    <template id="result-item-template">
                                        <div class="jp-result-item">
                                            <div class="jp-result-header">
                                                <h3 class="jp-result-title"></h3>
                                                <div class="jp-result-meta">
                                                    <span class="jp-category-badge"></span>
                                                    <span class="jp-type-badge"></span>
                                                </div>
                                            </div>
                                            <p class="jp-result-description"></p>
                                            
                                            <div class="jp-result-details">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="jp-detail-label">出版物:</p>
                                                        <p class="jp-detail-value publication"></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="jp-detail-label">号数:</p>
                                                        <p class="jp-detail-value issue-number"></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="jp-detail-label">日付:</p>
                                                        <p class="jp-detail-value date"></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="jp-content-preview">
                                                    <p class="jp-detail-label">内容抜粋:</p>
                                                    <p class="jp-content-text"></p>
                                                    <button class="jp-content-toggle btn btn-sm jp-btn-outline" type="button" 
                                                            data-bs-toggle="collapse" aria-expanded="false">
                                                        続きを読む <i class="fas fa-chevron-down ms-1"></i>
                                                    </button>
                                                    <div class="collapse">
                                                        <div class="jp-full-content"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                <?php else: ?>
                                    <div class="jp-no-results">
                                        <div class="jp-no-results-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <h3 class="jp-no-results-title">検索結果がありません</h3>
                                        <p class="jp-no-results-text">
                                            「<?php echo htmlspecialchars($query); ?>」に一致する結果は見つかりませんでした。<br>
                                            別のキーワードで検索してみてください。
                                        </p>
                                        <div class="mt-4">
                                            <a href="/search.php" class="btn jp-btn jp-btn-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>検索画面に戻る
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if(count($results) > 0): ?>
                            <div class="text-center mt-4">
                                <a href="/search.php" class="btn jp-btn jp-btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>検索画面に戻る
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
    
    <!-- AJAX Pagination script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables for pagination state
            let currentPage = 1;
            let totalPages = 1;
            let isLoading = false;
            let hasMoreResults = true;
            
            // References to DOM elements
            const resultsContainer = document.getElementById('results-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            const loadMoreContainer = document.getElementById('load-more-container');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const resultTemplate = document.getElementById('result-item-template');
            
            // Initial search parameters from URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchParams = {
                query: urlParams.get('query') || '',
                category: urlParams.getAll('category'),
                category_operator: urlParams.get('category_operator') || 'OR',
                type: urlParams.getAll('type'),
                type_operator: urlParams.get('type_operator') || 'OR',
                publication: urlParams.getAll('publication'),
                publication_operator: urlParams.get('publication_operator') || 'OR',
                issue_number: urlParams.get('issue_number') || '',
                content: urlParams.get('content') || '',
                date_from: urlParams.getAll('date_from'),
                date_to: urlParams.getAll('date_to'),
                date_operator: urlParams.get('date_operator') || 'OR',
                limit: 5, // Number of results per page
                page: currentPage
            };
            
            // Function to load search results via AJAX
            function loadSearchResults(page = 1) {
                if (isLoading || !hasMoreResults) return;
                
                isLoading = true;
                loadingIndicator.style.display = 'block';
                loadMoreContainer.style.display = 'none';
                
                // Update page parameter
                searchParams.page = page;
                
                // Convert search parameters to query string
                const queryParams = new URLSearchParams();
                
                // Add single parameters
                queryParams.append('query', searchParams.query);
                queryParams.append('category_operator', searchParams.category_operator);
                queryParams.append('type_operator', searchParams.type_operator);
                queryParams.append('publication_operator', searchParams.publication_operator);
                queryParams.append('issue_number', searchParams.issue_number);
                queryParams.append('content', searchParams.content);
                queryParams.append('date_operator', searchParams.date_operator);
                queryParams.append('limit', searchParams.limit);
                queryParams.append('page', searchParams.page);
                
                // Add array parameters
                searchParams.category.forEach(cat => {
                    if (cat) queryParams.append('category[]', cat);
                });
                
                searchParams.type.forEach(type => {
                    if (type) queryParams.append('type[]', type);
                });
                
                searchParams.publication.forEach(pub => {
                    if (pub) queryParams.append('publication[]', pub);
                });
                
                searchParams.date_from.forEach(date => {
                    if (date) queryParams.append('date_from[]', date);
                });
                
                searchParams.date_to.forEach(date => {
                    if (date) queryParams.append('date_to[]', date);
                });
                
                // Fetch results from API
                fetch(`/api/search_results.php?${queryParams.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update pagination state
                            totalPages = data.totalPages;
                            hasMoreResults = data.hasMore;
                            
                            // Render results
                            renderSearchResults(data.results);
                            
                            // Show load more button if there are more results
                            if (hasMoreResults) {
                                loadMoreContainer.style.display = 'block';
                            }
                        } else {
                            console.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    })
                    .finally(() => {
                        isLoading = false;
                        loadingIndicator.style.display = 'none';
                    });
            }
            
            // Function to render search results
            function renderSearchResults(results) {
                if (results.length === 0) return;
                
                results.forEach(result => {
                    // Clone the template
                    const template = resultTemplate.content.cloneNode(true);
                    
                    // Fill in the data
                    template.querySelector('.jp-result-title').textContent = result.title;
                    template.querySelector('.jp-category-badge').textContent = result.category;
                    template.querySelector('.jp-type-badge').textContent = result.type;
                    template.querySelector('.jp-result-description').textContent = result.description;
                    template.querySelector('.publication').textContent = result.publication;
                    template.querySelector('.issue-number').textContent = result.issue_number;
                    template.querySelector('.date').textContent = result.date;
                    
                    // Generate content preview and full content
                    const previewLength = 200;
                    const contentPreview = result.content.length > previewLength 
                        ? result.content.substring(0, previewLength) + '...' 
                        : result.content;
                        
                    template.querySelector('.jp-content-text').textContent = contentPreview;
                    template.querySelector('.jp-full-content').textContent = result.content;
                    
                    // Set up the read more toggle
                    const toggleButton = template.querySelector('.jp-content-toggle');
                    const collapseDiv = template.querySelector('.collapse');
                    
                    // Generate a unique ID for the collapse element based on the result ID
                    const collapseId = `content-${result.id}-${Math.random().toString(36).substring(2, 11)}`;
                    collapseDiv.id = collapseId;
                    toggleButton.setAttribute('data-bs-target', `#${collapseId}`);
                    
                    // Add the result item to the container
                    resultsContainer.appendChild(template);
                });
            }
            
            // Load more button click handler
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    currentPage++;
                    loadSearchResults(currentPage);
                });
            }
            
            // Infinite scroll handler
            const handleScroll = () => {
                const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
                
                if (scrollTop + clientHeight >= scrollHeight - 300 && !isLoading && hasMoreResults) {
                    currentPage++;
                    loadSearchResults(currentPage);
                }
            };
            
            // Attach scroll listener for infinite scroll
            window.addEventListener('scroll', handleScroll);
            
            // Load initial results
            loadSearchResults();
        });
    </script>
</body>
</html>