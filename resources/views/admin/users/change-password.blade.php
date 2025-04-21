@extends('layouts.admin')

@section('title', 'パスワード変更')

@section('content')
<div class="jp-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">パスワード変更</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-jp-secondary">
            <i class="bi bi-arrow-left me-2"></i>ユーザー一覧に戻る
        </a>
    </div>
    
    <div class="jp-card">
        <div class="card-header">
            <h5 class="mb-0">{{ $user->name }} さんのパスワードを変更</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update-password', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-3">
                    <label for="password" class="form-label jp-label">新しいパスワード</label>
                    <input type="password" class="form-control jp-form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">8文字以上で入力してください</div>
                </div>
                
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label jp-label">パスワード（確認）</label>
                    <input type="password" class="form-control jp-form-control" 
                           id="password_confirmation" name="password_confirmation" required>
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    パスワード変更後は、ユーザーに新しいパスワードを伝えてください。
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">キャンセル</a>
                    <button type="submit" class="btn btn-jp-primary">パスワードを変更</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection