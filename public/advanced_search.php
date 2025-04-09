<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>詳細検索 - 日本スタイルのウェブアプリケーション</title>
    
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
                            <a class="nav-link" href="/profile.php">プロフィール</a>
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
            <div class="jp-search-container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="jp-card">
                            <div class="jp-card-header">
                                <h1 class="jp-title text-center">詳細検索</h1>
                                <div class="jp-divider">
                                    <div class="jp-divider-inner"></div>
                                </div>
                                <p class="jp-search-summary text-center">
                                    複数の条件を組み合わせて検索できます
                                </p>
                            </div>
                            
                            <div class="jp-card-body">
                                <?php if (isset($_GET['error'])): ?>
                                    <div class="jp-alert jp-alert-danger">
                                        <ul class="mb-0">
                                            <li><?php echo htmlspecialchars($_GET['error']); ?></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="GET" action="search_results.php" id="advancedSearchForm">
                                    <div class="mb-4">
                                        <label for="query" class="form-label jp-label">検索キーワード</label>
                                        <div class="jp-input-wrapper">
                                            <input id="query" type="text" class="form-control jp-input" 
                                                name="query" value="" required>
                                        </div>
                                        <small class="form-text jp-small-text">※ 2文字以上で入力してください</small>
                                    </div>
                                    
                                    <!-- Logical operator selection for categories -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label jp-label">カテゴリー</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="jp-search-operator">
                                                <span class="jp-search-operator-label">検索条件:</span>
                                                <div class="jp-search-operator-options">
                                                    <div class="jp-search-operator-option active" data-value="OR">OR</div>
                                                    <div class="jp-search-operator-option" data-value="AND">AND</div>
                                                </div>
                                                <input type="hidden" name="category_operator" value="OR">
                                            </div>
                                            <div class="jp-multiselect-wrapper">
                                                <select id="category" class="form-select jp-multiselect-select" name="category[]" multiple data-placeholder="すべてのカテゴリー">
                                                    <option value="旅行">旅行</option>
                                                    <option value="料理">料理</option>
                                                    <option value="文学">文学</option>
                                                    <option value="文化">文化</option>
                                                    <option value="ニュース">ニュース</option>
                                                    <option value="スポーツ">スポーツ</option>
                                                    <option value="経済">経済</option>
                                                    <option value="政治">政治</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Logical operator selection for types -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label jp-label">種類</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="jp-search-operator">
                                                <span class="jp-search-operator-label">検索条件:</span>
                                                <div class="jp-search-operator-options">
                                                    <div class="jp-search-operator-option active" data-value="OR">OR</div>
                                                    <div class="jp-search-operator-option" data-value="AND">AND</div>
                                                </div>
                                                <input type="hidden" name="type_operator" value="OR">
                                            </div>
                                            <div class="jp-multiselect-wrapper">
                                                <select id="type" class="form-select jp-multiselect-select" name="type[]" multiple data-placeholder="すべての種類">
                                                    <option value="記事">記事</option>
                                                    <option value="コラム">コラム</option>
                                                    <option value="インタビュー">インタビュー</option>
                                                    <option value="レビュー">レビュー</option>
                                                    <option value="ガイド">ガイド</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Logical operator selection for publications -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label jp-label">出版物</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="jp-search-operator">
                                                <span class="jp-search-operator-label">検索条件:</span>
                                                <div class="jp-search-operator-options">
                                                    <div class="jp-search-operator-option active" data-value="OR">OR</div>
                                                    <div class="jp-search-operator-option" data-value="AND">AND</div>
                                                </div>
                                                <input type="hidden" name="publication_operator" value="OR">
                                            </div>
                                            <div class="jp-multiselect-wrapper">
                                                <select id="publication" class="form-select jp-multiselect-select" name="publication[]" multiple data-placeholder="すべての出版物">
                                                    <option value="日経新聞">日経新聞</option>
                                                    <option value="朝日新聞">朝日新聞</option>
                                                    <option value="読売新聞">読売新聞</option>
                                                    <option value="毎日新聞">毎日新聞</option>
                                                    <option value="産経新聞">産経新聞</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="issue_number" class="form-label jp-label">号数</label>
                                        <div class="jp-input-wrapper">
                                            <input id="issue_number" type="text" class="form-control jp-input" 
                                                name="issue_number" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="content" class="form-label jp-label">内容</label>
                                        <div class="jp-input-wrapper">
                                            <input id="content" type="text" class="form-control jp-input" 
                                                name="content" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Date Range Selection with Multiple Ranges -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label jp-label mb-0">期間</label>
                                            
                                            <!-- Logical operator selection for dates -->
                                            <div class="jp-search-operator">
                                                <span class="jp-search-operator-label">検索条件:</span>
                                                <div class="jp-search-operator-options">
                                                    <div class="jp-search-operator-option active" data-value="OR">OR</div>
                                                    <div class="jp-search-operator-option" data-value="AND">AND</div>
                                                </div>
                                                <input type="hidden" name="date_operator" value="OR">
                                            </div>
                                        </div>
                                        
                                        <!-- Initial date range -->
                                        <div class="jp-date-range-container">
                                            <div class="jp-date-range mb-3">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="jp-input-wrapper">
                                                            <input type="date" class="form-control jp-input date-from" 
                                                                name="date_from[]" value="">
                                                            <label class="jp-small-text">開始日</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-center py-2">
                                                        <span class="jp-date-separator">～</span>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="jp-input-wrapper">
                                                            <input type="date" class="form-control jp-input date-to" 
                                                                name="date_to[]" value="">
                                                            <label class="jp-small-text">終了日</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm jp-btn-icon jp-remove-date-range">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Button to add another date range -->
                                        <button type="button" class="btn btn-sm jp-btn-outline" id="addDateRange">
                                            <i class="fas fa-plus me-1"></i> 別の期間を追加
                                        </button>
                                    </div>
                                    
                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" class="btn jp-btn jp-btn-primary">
                                            <i class="fas fa-search me-2"></i>検索する
                                        </button>
                                    </div>
                                    
                                    <div class="text-center mt-3">
                                        <a href="/search.php" class="jp-link">
                                            <i class="fas fa-arrow-left me-1"></i> 通常検索に戻る
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    
    <!-- Custom validation script -->
    <script src="js/validation.js"></script>
    
    <!-- Advanced search functionality -->
    <script src="js/advanced-search.js"></script>
    
    <!-- Zen mode script -->
    <script src="js/zen-mode.js"></script>
</body>
</html>