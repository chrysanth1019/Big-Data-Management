<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログイン</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Shippori+Mincho:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        body {
            background-color: var(--jp-cream);
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d05a6e' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 25a25 25 0 1 0 0 50 25 25 0 0 0 0-50zm0 40a15 15 0 1 1 0-30 15 15 0 0 1 0 30z' fill='%23d05a6e' fill-opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
            z-index: -1;
        }
        
        .login-container {
            max-width: 400px;
            width: 100%;
        }
        
        .login-logo {
            font-family: 'Shippori Mincho', serif;
            color: var(--jp-red);
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            padding-bottom: 0.5rem;
            letter-spacing: 0.1em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .login-logo::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background-color: var(--jp-gold);
        }
        
        .login-card {
            background-color: white;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--jp-red), var(--jp-gold));
        }
        
        .jp-form-control {
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .jp-form-control:focus {
            border-color: var(--jp-red);
            box-shadow: 0 0 0 0.2rem rgba(208, 90, 110, 0.15);
        }
        
        .jp-label {
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .login-btn {
            background-color: var(--jp-red);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(208, 90, 110, 0.2);
            transition: all 0.3s;
            width: 100%;
            font-weight: 500;
            letter-spacing: 0.05em;
            position: relative;
            overflow: hidden;
        }
        
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.4s ease;
        }
        
        .login-btn:hover {
            background-color: #C04050;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(208, 90, 110, 0.25);
        }
        
        .login-btn:hover::before {
            left: 100%;
        }
    </style>
</head>
<body>
    <div class="login-container jp-fade-in">
        <!-- <div class="login-logo">管理パネル</div> -->
        
        <div class="login-card card">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">ログイン</h4>
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="jp-label">メールアドレス</label>
                        <input id="email" type="email" class="form-control jp-form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="jp-label">パスワード</label>
                        <input id="password" type="password" class="form-control jp-form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            ログイン状態を保存する
                        </label>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="login-btn">
                            ログイン <i class="bi bi-arrow-right-circle ms-1"></i>
                        </button>
                    </div>
                    <div class="mb-3 form-group">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted small">
            &copy; {{ date('Y') }} Data service Application. All rights reserved.
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {!! NoCaptcha::renderJs() !!}
</body>
</html>