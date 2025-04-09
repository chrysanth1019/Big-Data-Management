<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ようこそ - 日本スタイルのウェブアプリケーション</title>
    
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
                            <a class="nav-link" href="/login.php">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register.php">登録</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="jp-main">
        <div class="jp-welcome-page">
            <div class="jp-hero">
                <div class="jp-hero-content">
                    <div class="jp-hero-text-container">
                        <h1 class="jp-hero-title">和の雰囲気で<br>データを検索</h1>
                        <p class="jp-hero-subtitle">
                            日本の伝統的な美学を取り入れた<br>
                            使いやすいデータ検索アプリケーション
                        </p>
                        <div class="jp-hero-buttons">
                            <a href="/login.php" class="btn jp-btn jp-btn-primary me-3">
                                ログイン
                            </a>
                            <a href="/register.php" class="btn jp-btn jp-btn-outline">
                                新規登録
                            </a>
                        </div>
                    </div>
                    <div class="jp-hero-pattern"></div>
                </div>
            </div>
            
            <div class="jp-features">
                <div class="container">
                    <h2 class="jp-section-title text-center">主な特徴</h2>
                    <div class="jp-divider-center">
                        <div class="jp-divider-inner"></div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-4 mb-4">
                            <div class="jp-feature-card">
                                <div class="jp-feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="jp-feature-title">簡単アカウント作成</h3>
                                <p class="jp-feature-text">
                                    数ステップで登録できる簡単なアカウント作成プロセス。
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="jp-feature-card">
                                <div class="jp-feature-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3 class="jp-feature-title">効率的な検索</h3>
                                <p class="jp-feature-text">
                                    キーワードやカテゴリから、必要な情報を素早く見つけることができます。
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="jp-feature-card">
                                <div class="jp-feature-icon">
                                    <i class="fas fa-paint-brush"></i>
                                </div>
                                <h3 class="jp-feature-title">和のデザイン</h3>
                                <p class="jp-feature-text">
                                    日本の伝統的な美学を取り入れた、落ち着きのあるインターフェース。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="jp-cta-section">
                <div class="container">
                    <div class="jp-cta-inner">
                        <h2 class="jp-cta-title">今すぐ始めましょう</h2>
                        <p class="jp-cta-text">
                            アカウントを作成して、日本スタイルのデータ検索アプリケーションをご利用ください。
                        </p>
                        <div class="jp-cta-button">
                            <a href="/register.php" class="btn jp-btn jp-btn-primary jp-btn-lg">
                                無料で登録する
                            </a>
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
</body>
</html>