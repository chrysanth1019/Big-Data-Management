<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録 - 日本スタイルのウェブアプリケーション</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Japanese fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
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
        <div class="container py-4">
            <div class="jp-auth-container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="jp-card">
                            <div class="jp-card-header">
                                <h1 class="jp-title text-center">新規登録</h1>
                                <div class="jp-divider">
                                    <div class="jp-divider-inner"></div>
                                </div>
                            </div>
                            
                            <div class="jp-card-body">
                                <?php if (isset($_GET['error'])): ?>
                                    <div class="jp-alert jp-alert-danger">
                                        <ul class="mb-0">
                                            <li><?php echo htmlspecialchars($_GET['error']); ?></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="register_process.php" id="registerForm">
                                    <div class="mb-4">
                                        <label for="name" class="form-label jp-label">名前</label>
                                        <div class="jp-input-wrapper">
                                            <input id="name" type="text" class="form-control jp-input" 
                                                name="name" value="" required autocomplete="name" autofocus>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="email" class="form-label jp-label">メールアドレス</label>
                                        <div class="jp-input-wrapper">
                                            <input id="email" type="email" class="form-control jp-input" 
                                                name="email" value="" required autocomplete="email">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password" class="form-label jp-label">パスワード</label>
                                        <div class="jp-input-wrapper">
                                            <input id="password" type="password" 
                                                class="form-control jp-input" 
                                                name="password" required autocomplete="new-password">
                                        </div>
                                        <small class="form-text jp-small-text">※ パスワードは8文字以上で設定してください</small>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password-confirm" class="form-label jp-label">パスワード（確認）</label>
                                        <div class="jp-input-wrapper">
                                            <input id="password-confirm" type="password" class="form-control jp-input" 
                                                name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label jp-label">セキュリティ確認</label>
                                        <div class="g-recaptcha" data-sitekey="<?php echo getenv('RECAPTCHA_SITE_KEY'); ?>"></div>
                                        <small class="form-text jp-form-text mt-2">
                                            <i class="fas fa-info-circle me-1"></i>「私はロボットではありません」にチェックを入れてください。
                                        </small>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn jp-btn jp-btn-primary">
                                            登録する
                                        </button>
                                    </div>
                                    
                                    <div class="mt-4 text-center">
                                        <p class="jp-text">
                                            既にアカウントをお持ちの方は<a href="/login.php" class="jp-link">こちら</a>からログインできます。
                                        </p>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('registerForm');
            
            if (registerForm) {
                registerForm.addEventListener('submit', function(event) {
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const passwordConfirm = document.getElementById('password-confirm').value;
                    const recaptchaResponse = grecaptcha.getResponse();
                    let isValid = true;
                    
                    // Clear previous error messages
                    document.querySelectorAll('.jp-error-message').forEach(el => {
                        el.remove();
                    });
                    
                    // Name validation
                    if (!name) {
                        isValid = false;
                        const nameInput = document.getElementById('name');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = '名前を入力してください。';
                        nameInput.parentNode.after(errorMessage);
                    }
                    
                    // Email validation
                    if (!email || !validateEmail(email)) {
                        isValid = false;
                        const emailInput = document.getElementById('email');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = '有効なメールアドレスを入力してください。';
                        emailInput.parentNode.after(errorMessage);
                    }
                    
                    // Password validation
                    if (!password || password.length < 8) {
                        isValid = false;
                        const passwordInput = document.getElementById('password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードは8文字以上で入力してください。';
                        passwordInput.parentNode.after(errorMessage);
                    }
                    
                    // Password confirmation validation
                    if (password !== passwordConfirm) {
                        isValid = false;
                        const passwordConfirmInput = document.getElementById('password-confirm');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードが一致しません。';
                        passwordConfirmInput.parentNode.after(errorMessage);
                    }
                    
                    // reCAPTCHA validation
                    if (!recaptchaResponse) {
                        isValid = false;
                        const recaptchaContainer = document.querySelector('.g-recaptcha');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'セキュリティ確認にチェックを入れてください。';
                        recaptchaContainer.after(errorMessage);
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