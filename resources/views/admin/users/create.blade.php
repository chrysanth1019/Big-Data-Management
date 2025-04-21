@extends('layouts.admin')

@section('title', 'ユーザー追加')

@section('content')
<div class="jp-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">ユーザー追加</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-jp-secondary">
            <i class="bi bi-arrow-left me-2"></i>ユーザー一覧に戻る
        </a>
    </div>
    
    <div class="jp-card">
        <div class="card-header">
            <h5 class="mb-0">新規ユーザー情報</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label jp-label">名前</label>
                    <input type="text" class="form-control jp-form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label jp-label">メールアドレス</label>
                    <input type="email" class="form-control jp-form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">管理者権限を付与する</label>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    ユーザーにはデフォルトパスワード「password123」が設定されます。後からパスワード変更が可能です。
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">キャンセル</a>
                    <button type="submit" class="btn btn-jp-primary">ユーザーを作成</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection