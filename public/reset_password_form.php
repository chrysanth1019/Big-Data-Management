<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>新しいパスワード - 日本スタイルのウェブアプリケーション</title>
    
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
                                <h1 class="jp-title text-center">新しいパスワード</h1>
                                <div class="jp-divider">
                                    <div class="jp-divider-inner"></div>
                                </div>
                            </div>
                            
                            <div class="jp-card-body">
                                <?php
                                // Check if token and email are set
                                if (!isset($_GET['token']) || !isset($_GET['email']) || empty($_GET['token']) || empty($_GET['email'])) {
                                    echo '<div class="jp-alert jp-alert-danger">
                                            <p class="mb-0">無効なリクエストです。パスワードリセットのリンクが正しくないか、期限切れです。</p>
                                          </div>
                                          <div class="mb-4 mt-4 text-center">
                                            <a href="/forgot_password.php" class="btn jp-btn jp-btn-secondary">
                                                <i class="fas fa-repeat me-2"></i>パスワードリセットをやり直す
                                            </a>
                                          </div>';
                                } else {
                                    // In a real application, you'd validate the token against the database
                                    // For demo purposes, we'll just show the form
                                    $token = htmlspecialchars($_GET['token']);
                                    $email = htmlspecialchars($_GET['email']);
                                ?>
                                    <?php if (isset($_GET['error'])): ?>
                                        <div class="jp-alert jp-alert-danger">
                                            <ul class="mb-0">
                                                <li><?php echo htmlspecialchars($_GET['error']); ?></li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p class="jp-text mb-4">新しいパスワードを設定してください。</p>
                                    
                                    <form method="POST" action="reset_password_complete.php" id="resetPasswordForm">
                                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                                        
                                        <div class="mb-4">
                                            <label for="password" class="form-label jp-label">新しいパスワード</label>
                                            <div class="jp-input-wrapper">
                                                <input id="password" type="password" class="form-control jp-input" 
                                                    name="password" required autocomplete="new-password">
                                            </div>
                                            <small class="form-text jp-form-text">
                                                パスワードは8文字以上で、英字、数字、記号を含める必要があります。
                                            </small>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="password_confirm" class="form-label jp-label">新しいパスワード（確認）</label>
                                            <div class="jp-input-wrapper">
                                                <input id="password_confirm" type="password" class="form-control jp-input" 
                                                    name="password_confirm" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 mt-4">
                                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                                パスワードを変更する
                                            </button>
                                        </div>
                                    </form>
                                <?php } ?>
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
            const resetPasswordForm = document.getElementById('resetPasswordForm');
            
            if (resetPasswordForm) {
                resetPasswordForm.addEventListener('submit', function(event) {
                    const password = document.getElementById('password').value;
                    const passwordConfirm = document.getElementById('password_confirm').value;
                    let isValid = true;
                    
                    // Clear previous error messages
                    document.querySelectorAll('.jp-error-message').forEach(el => {
                        el.remove();
                    });
                    
                    // Password validation
                    if (!password || password.length < 8) {
                        isValid = false;
                        const passwordInput = document.getElementById('password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードは8文字以上で入力してください。';
                        passwordInput.parentNode.after(errorMessage);
                    } else if (!checkPasswordStrength(password)) {
                        isValid = false;
                        const passwordInput = document.getElementById('password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードは英字、数字、記号を含める必要があります。';
                        passwordInput.parentNode.after(errorMessage);
                    }
                    
                    // Password confirmation
                    if (password !== passwordConfirm) {
                        isValid = false;
                        const passwordConfirmInput = document.getElementById('password_confirm');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードが一致しません。';
                        passwordConfirmInput.parentNode.after(errorMessage);
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