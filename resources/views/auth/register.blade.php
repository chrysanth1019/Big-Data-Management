@extends('layouts.app')

@section('title', '新規登録')

@section('content')
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
                    @if ($errors->any())
                        <div class="jp-alert jp-alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label jp-label">名前</label>
                            <div class="jp-input-wrapper">
                                <input id="name" type="text" class="form-control jp-input @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name">
                            </div>
                            @error('name')
                                <span class="jp-error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label jp-label">メールアドレス</label>
                            <div class="jp-input-wrapper">
                                <input id="email" type="email" class="form-control jp-input @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                       name="password" required autocomplete="new-password">
                            </div>
                            <small class="form-text jp-small-text">※ パスワードは8文字以上で設定してください</small>
                            @error('password')
                                <span class="jp-error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label jp-label">パスワード（確認）</label>
                            <div class="jp-input-wrapper">
                                <input id="password-confirm" type="password" class="form-control jp-input" 
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                登録する
                            </button>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <p class="jp-text">
                                既にアカウントをお持ちの方は<a href="{{ route('login') }}" class="jp-link">こちら</a>からログインできます。
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
        const registerForm = document.getElementById('registerForm');
        
        if (registerForm) {
            registerForm.addEventListener('submit', function(event) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password-confirm').value;
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
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    });
</script>
@endsection
