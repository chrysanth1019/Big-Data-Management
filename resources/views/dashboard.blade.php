@extends('layouts.app')

@section('title', 'ダッシュボード')

@section('content')
<div class="jp-dashboard-container">
    <div class="jp-welcome-banner">
        <div class="jp-welcome-content">
            <h1 class="jp-welcome-title">ようこそ、{{ Auth::user()->name }} 様</h1>
            <p class="jp-welcome-text">システムをご利用いただき、ありがとうございます。</p>
        </div>
        <div class="jp-welcome-pattern"></div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="jp-card jp-card-action">
                <div class="jp-card-body text-center">
                    <div class="jp-icon-circle mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2 class="jp-action-title">データを検索する</h2>
                    <p class="jp-action-text">
                        キーワードやカテゴリーから必要な情報を検索できます。
                    </p>
                    <a href="{{ route('search.index') }}" class="btn jp-btn jp-btn-primary mt-3">
                        検索ページへ
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="jp-card jp-card-action">
                <div class="jp-card-body text-center">
                    <div class="jp-icon-circle mb-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="jp-action-title">アカウント情報</h2>
                    <p class="jp-action-text">
                        ログイン情報: {{ Auth::user()->email }}<br>
                        登録日時: {{ Auth::user()->created_at->format('Y年m月d日') }}
                    </p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn jp-btn jp-btn-secondary mt-3">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
