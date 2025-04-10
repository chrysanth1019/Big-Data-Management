@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="jp-auth-container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="jp-card">
                <div class="jp-card-header">
                    <h1 class="jp-title text-center">ログイン</h1>
                    <div class="jp-divider">
                        <div class="jp-divider-inner"></div>
                    </div>
                </div>
                
                <div class="jp-card-body">
                    @if ($errors->any())
                        <div class="jp-alert jp-alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label jp-label">メールアドレス</label>
                            <div class="jp-input-wrapper">
                                <input id="email" type="email" class="form-control jp-input @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span class="jp-error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label jp-label">パスワード</label>
                            <div class="jp-input-wrapper">
                                <input id="password" type="password" 
                                       class="form-control jp-input @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <span class="jp-error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" 
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label jp-check-label" for="remember">
                                    ログイン情報を保存する
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                ログイン
                            </button>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <p class="jp-text">
                                アカウントをお持ちでない方は<a href="{{ route('register') }}" class="jp-link">こちら</a>から登録できます。
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        
        if (loginForm) {
            loginForm.addEventListener('submit', function(event) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
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
                
                // Password validation
                if (!password) {
                    isValid = false;
                    const passwordInput = document.getElementById('password');
                    const errorMessage = document.createElement('span');
                    errorMessage.className = 'jp-error-message';
                    errorMessage.textContent = 'パスワードを入力してください。';
                    passwordInput.parentNode.after(errorMessage);
                }
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    });
</script>
@endsection
