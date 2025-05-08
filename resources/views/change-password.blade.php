<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード変更 - データサービス</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts (Shippori Mincho) -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --jp-navy: #1a2639;
            --jp-blue: #1565C0;
            --jp-red: #B71C1C;
            --jp-gold: #FFC107;
            --jp-light-bg: #F5F7FA;
            --jp-text: #263238;
        }
        
        body {
            font-family: "Noto Sans JP", "Hiragino Sans", "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
            background-color: var(--jp-light-bg);
            color: var(--jp-text);
        }
        
        .jp-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.5rem 1rem;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        
        .logo-text {
            font-family: 'Shippori Mincho', serif;
            font-size: 1.4rem;
            margin-left: 0.5rem;
            color: var(--jp-navy);
            font-weight: 600;
        }
        
        .jp-nav-link {
            color: var(--jp-navy);
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            position: relative;
            transition: all 0.3s;
        }
        
        .jp-card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .jp-card-header {
            background: linear-gradient(45deg, #236bca 0%, #236bca 100%)
            color: white;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }
        
        .jp-form-input {
            padding: 0.6rem 1rem;
            border: 1px solid #E0E0E0;
            transition: all 0.3s;
        }
        
        .jp-form-input:focus {
            border-color: var(--jp-blue);
            box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.25);
        }
        
        .jp-input-icon {
            background-color: var(--jp-light-bg);
            border: 1px solid #E0E0E0;
            border-right: none;
            color: var(--jp-navy);
        }
        
        .jp-btn-primary {
            background: linear-gradient(45deg, var(--jp-blue) 0%, #1976D2 100%);
            border: none;
            padding: 0.6rem 2rem;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(21, 101, 192, 0.3);
            transition: all 0.3s;
        }
        
        .jp-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(21, 101, 192, 0.4);
        }
        
        /* Password strength styles */
        .password-strength-meter .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #f0f0f0;
        }
        
        .password-strength-meter .progress-bar {
            transition: width 0.3s, background-color 0.3s;
        }
        
        .password-strength-meter .progress-bar.bg-danger {
            background-color: #dc3545 !important;
        }
        
        .password-strength-meter .progress-bar.bg-warning {
            background-color: #ffc107 !important;
        }
        
        .password-strength-meter .progress-bar.bg-info {
            background-color: #17a2b8 !important;
        }
        
        .password-strength-meter .progress-bar.bg-success {
            background-color: #28a745 !important;
        }
        
        .password-requirements .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        .password-requirements .form-text i.bi-check-circle {
            color: #adb5bd;
            opacity: 0.5;
        }
        
        .password-requirements .form-text i.bi-check-circle.text-success {
            color: #28a745 !important;
            opacity: 1;
        }
        
        .footer {
            background-color: var(--jp-navy);
            color: rgba(255, 255, 255, 0.7);
            padding: 1rem 0;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    
            
    @include('partials.topbar')

    <!-- Main Content -->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card jp-card">
                    <div class="card-header jp-card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-key-fill me-2"></i>パスワード変更
                        </h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>入力内容を確認してください
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}" id="passwordForm">
                            @csrf

                            <div class="mb-4">
                                <label for="current_password" class="form-label">現在のパスワード</label>
                                <div class="input-group">
                                    <span class="input-group-text jp-input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input id="current_password" type="password" 
                                        class="form-control jp-form-input @error('current_password') is-invalid @enderror" 
                                        name="current_password" required autocomplete="current-password">
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">新しいパスワード</label>
                                <div class="input-group">
                                    <span class="input-group-text jp-input-icon">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </span>
                                    <input id="password" type="password" 
                                        class="form-control jp-form-input @error('password') is-invalid @enderror" 
                                        name="password" required autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="password-strength-meter mt-2">
                                    <div class="progress">
                                        <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div id="password-strength-text" class="form-text mt-1">
                                        <i class="bi bi-info-circle me-1"></i>
                                        パスワード強度: <span id="strength-value">未入力</span>
                                    </div>
                                </div>
                                <div class="password-requirements mt-2">
                                    <div class="form-text">
                                        <i class="bi bi-check-circle me-1" id="length-check"></i>
                                        8文字以上
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-check-circle me-1" id="uppercase-check"></i>
                                        大文字(A-Z)を含む
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-check-circle me-1" id="lowercase-check"></i>
                                        小文字(a-z)を含む
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-check-circle me-1" id="number-check"></i>
                                        数字(0-9)を含む
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-check-circle me-1" id="special-check"></i>
                                        特殊文字(!@#$%^&*)を含む
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">新しいパスワード（確認）</label>
                                <div class="input-group">
                                    <span class="input-group-text jp-input-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    <input id="password-confirm" type="password" 
                                        class="form-control jp-form-input" 
                                        name="password_confirmation" required autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="bi bi-eye-slash" id="toggleConfirmIcon"></i>
                                    </button>
                                </div>
                                <div id="password-match-status" class="form-text mt-2 d-none">
                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                    パスワードが一致しています
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('simple-search.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-search me-1"></i>検索ページへ</a>
                                <button type="submit" class="btn btn-primary jp-btn-primary">
                                    <i class="bi bi-save2 me-1"></i>パスワードを変更する
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Strength Checker -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password-confirm');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthValue = document.getElementById('strength-value');
        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const numberCheck = document.getElementById('number-check');
        const specialCheck = document.getElementById('special-check');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
        const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');
        const passwordMatchStatus = document.getElementById('password-match-status');
        
        // Show/hide password
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            if (type === 'text') {
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        });
        
        // Show/hide confirm password
        toggleConfirmPasswordBtn.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            
            // Toggle the eye icon
            if (type === 'text') {
                toggleConfirmIcon.classList.remove('bi-eye-slash');
                toggleConfirmIcon.classList.add('bi-eye');
            } else {
                toggleConfirmIcon.classList.remove('bi-eye');
                toggleConfirmIcon.classList.add('bi-eye-slash');
            }
        });
        
        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            
            // Check requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Update requirement checks
            toggleCheck(lengthCheck, hasLength);
            toggleCheck(uppercaseCheck, hasUppercase);
            toggleCheck(lowercaseCheck, hasLowercase);
            toggleCheck(numberCheck, hasNumber);
            toggleCheck(specialCheck, hasSpecial);
            
            // Calculate strength score (0-4)
            let strength = 0;
            if (password.length > 0) strength++; // At least some characters
            if (hasLength) strength++;
            if ((hasUppercase && hasLowercase) || (hasNumber && hasSpecial)) strength++;
            if (hasUppercase && hasLowercase && (hasNumber || hasSpecial)) strength++;
            if (hasUppercase && hasLowercase && hasNumber && hasSpecial) strength++;
            
            // Update strength bar
            updateStrengthBar(strength);
            
            // Check password match if confirm field has content
            if (passwordConfirmInput.value.length > 0) {
                checkPasswordsMatch();
            }
        });
        
        function updateStrengthBar(strength) {
            // Define color classes and labels based on strength
            const strengthClasses = ['bg-danger', 'bg-danger', 'bg-warning', 'bg-info', 'bg-success'];
            const strengthLabels = ['非常に弱い', '弱い', '普通', '強い', '非常に強い'];
            
            // Remove all classes
            strengthBar.className = 'progress-bar';
            
            // If password is empty
            if (passwordInput.value.length === 0) {
                strengthBar.style.width = '0%';
                strengthValue.textContent = '未入力';
                return;
            }
            
            // Add appropriate class and update width
            const percentage = (strength / 4) * 100;
            strengthBar.classList.add(strengthClasses[strength]);
            strengthBar.style.width = percentage + '%';
            strengthBar.setAttribute('aria-valuenow', percentage);
            
            // Update text
            strengthValue.textContent = strengthLabels[strength];
        }
        
        function toggleCheck(element, isValid) {
            if (isValid) {
                element.classList.add('text-success');
            } else {
                element.classList.remove('text-success');
            }
        }
        
        // Check if passwords match
        function checkPasswordsMatch() {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmInput.value;
            
            if (confirmPassword.length === 0) {
                passwordMatchStatus.classList.add('d-none');
                return;
            }
            
            if (password === confirmPassword) {
                passwordMatchStatus.classList.remove('d-none');
            } else {
                passwordMatchStatus.classList.add('d-none');
            }
        }
        
        // Add event listeners for password matching
        passwordConfirmInput.addEventListener('input', checkPasswordsMatch);
        
        // Form validation before submission
        const passwordForm = document.getElementById('passwordForm');
        passwordForm.addEventListener('submit', function(event) {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmInput.value;
            
            // Check password requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Check if all requirements are met
            const isValid = hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;
            
            // Check if passwords match
            const passwordsMatch = password === confirmPassword;
            
            if (!isValid || !passwordsMatch) {
                event.preventDefault();
                
                // Create alert for validation errors
                const alertContainer = document.createElement('div');
                alertContainer.className = 'alert alert-danger mt-3';
                alertContainer.role = 'alert';
                
                let errorMessage = '';
                
                if (!isValid) {
                    errorMessage += '<i class="bi bi-exclamation-triangle-fill me-2"></i>パスワードは以下の条件を満たす必要があります：<ul>';
                    if (!hasLength) errorMessage += '<li>8文字以上</li>';
                    if (!hasUppercase) errorMessage += '<li>大文字(A-Z)を含む</li>';
                    if (!hasLowercase) errorMessage += '<li>小文字(a-z)を含む</li>';
                    if (!hasNumber) errorMessage += '<li>数字(0-9)を含む</li>';
                    if (!hasSpecial) errorMessage += '<li>特殊文字(!@#$%^&*)を含む</li>';
                    errorMessage += '</ul>';
                }
                
                if (!passwordsMatch) {
                    errorMessage += '<i class="bi bi-exclamation-triangle-fill me-2"></i>パスワードが一致していません。';
                }
                
                alertContainer.innerHTML = errorMessage;
                
                // Add alert before form
                const card = document.querySelector('.card-body');
                const existingAlert = card.querySelector('.alert-danger');
                
                if (existingAlert) {
                    existingAlert.remove();
                }
                
                card.insertBefore(alertContainer, passwordForm);
                
                // Scroll to top of form
                card.scrollIntoView({behavior: 'smooth'});
            }
        });
    });
    </script>
</body>
</html>