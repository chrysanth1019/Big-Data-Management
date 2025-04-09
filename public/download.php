<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ソースコードのダウンロード - 日本スタイルのウェブアプリケーション</title>
    
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
                            <a class="nav-link" href="/search.php">検索</a>
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
        <div class="container py-5">
            <div class="jp-card">
                <div class="jp-card-header">
                    <h1 class="jp-title text-center">ソースコードのダウンロード</h1>
                    <div class="jp-divider">
                        <div class="jp-divider-inner"></div>
                    </div>
                </div>
                
                <div class="jp-card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-download fa-4x text-primary mb-3"></i>
                        <h2 class="h4 mb-3">日本スタイルの検索アプリケーション</h2>
                        <p class="mb-4">
                            日本語デザインを取り入れた検索アプリケーションの完全なソースコードをダウンロードします。<br>
                            このパッケージには以下が含まれています：
                        </p>
                        
                        <ul class="list-unstyled text-start mx-auto" style="max-width: 500px;">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> PHPバックエンド</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 日本語スタイルのUI</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 高度な検索機能</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> AJAX ページネーション</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> レスポンシブなモバイルデザイン</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> reCAPTCHA統合</li>
                        </ul>
                    </div>
                    
                    <a href="download_source.php" class="btn jp-btn jp-btn-primary btn-lg">
                        <i class="fas fa-download me-2"></i> ソースコードをダウンロード
                    </a>
                    
                    <p class="mt-4 small text-muted">
                        このアプリケーションは教育目的のために提供されています。<br>
                        商用利用の場合は、適切なライセンスを取得してください。
                    </p>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="/" class="btn jp-btn jp-btn-outline">
                    <i class="fas fa-arrow-left me-2"></i> ホームに戻る
                </a>
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
</body>
</html>