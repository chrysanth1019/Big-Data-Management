<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>パスワードリセット - 日本スタイルのウェブアプリケーション</title>
    
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
        <div class="container py-4">
            <div class="jp-auth-container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="jp-card">
                            <div class="jp-card-header">
                                <h1 class="jp-title text-center">パスワードリセット</h1>
                                <div class="jp-divider">
                                    <div class="jp-divider-inner"></div>
                                </div>
                            </div>
                            
                            <div class="jp-card-body">
                                <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                                    <div class="jp-alert jp-alert-success">
                                        <p class="mb-0">パスワードリセットのリンクを送信しました。メールをご確認ください。</p>
                                    </div>
                                    <div class="mb-4 mt-4 text-center">
                                        <a href="/login.php" class="btn jp-btn jp-btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>ログインページへ戻る
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <?php if (isset($_GET['error'])): ?>
                                        <div class="jp-alert jp-alert-danger">
                                            <ul class="mb-0">
                                                <li><?php echo htmlspecialchars($_GET['error']); ?></li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p class="jp-text mb-4">登録したメールアドレスを入力してください。パスワードリセットのリンクを送信します。</p>
                                    
                                    <form method="POST" action="reset_password_process.php" id="forgotPasswordForm">
                                        <div class="mb-4">
                                            <label for="email" class="form-label jp-label">メールアドレス</label>
                                            <div class="jp-input-wrapper">
                                                <input id="email" type="email" class="form-control jp-input" 
                                                    name="email" value="" required autocomplete="email" autofocus>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                                リセットリンクを送信
                                            </button>
                                        </div>
                                        
                                        <div class="mt-4 text-center">
                                            <p class="jp-text">
                                                <a href="/login.php" class="jp-link"><i class="fas fa-arrow-left me-1"></i> ログインページへ戻る</a>
                                            </p>
                                        </div>
                                    </form>
                                <?php endif; ?>
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
    
    <!-- Zen mode script -->
    <script src="js/zen-mode.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forgotPasswordForm = document.getElementById('forgotPasswordForm');
            
            if (forgotPasswordForm) {
                forgotPasswordForm.addEventListener('submit', function(event) {
                    const email = document.getElementById('email').value;
                    let isValid = true;
                    
                    // Clear previous error messages
                    document.querySelectorAll('.jp-error-message').forEach(el => {
                        el.remove();
                    });
                    
                    // Email validation
                    if (!email || !validateEmail(email)) {
                        isValid = false;
                        const emailInput = document.getElementById('email');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = '有効なメールアドレスを入力してください。';
                        emailInput.parentNode.after(errorMessage);
                    }
                    
                    if (!isValid) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>