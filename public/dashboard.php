<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード - 日本スタイルのウェブアプリケーション</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Japanese fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Japanese-style CSS -->
    <link href="css/japanese-style.css" rel="stylesheet">
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
            <div class="jp-dashboard-container">
                <div class="jp-welcome-banner">
                    <div class="jp-welcome-content">
                        <h1 class="jp-welcome-title">ようこそ、ユーザーさん</h1>
                        <p class="jp-welcome-text">日本スタイルのデータ検索アプリをご利用いただき、ありがとうございます。</p>
                    </div>
                    <div class="jp-welcome-pattern"></div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-md-6 mb-4">
                        <div class="jp-card jp-card-action">
                            <div class="jp-card-body text-center">
                                <div class="jp-icon-circle mb-3">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h2 class="jp-action-title">データを検索する</h2>
                                <p class="jp-action-text">
                                    キーワードやカテゴリーから必要な情報を検索できます。
                                </p>
                                <a href="/search.php" class="btn jp-btn jp-btn-primary mt-3">
                                    検索ページへ
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="jp-card jp-card-action">
                            <div class="jp-card-body text-center">
                                <div class="jp-icon-circle mb-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h2 class="jp-action-title">アカウント情報</h2>
                                <p class="jp-action-text">
                                    ログイン情報: demo@example.com<br>
                                    登録日時: <?php echo date('Y年m月d日'); ?>
                                </p>
                                <a href="/login.php" class="btn jp-btn jp-btn-secondary mt-3">
                                    ログアウト
                                </a>
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
</body>
</html>