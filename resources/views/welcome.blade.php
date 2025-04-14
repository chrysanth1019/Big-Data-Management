@extends('layouts.app')

@section('title', 'ようこそ')

@section('content')
<div class="jp-welcome-page">
    <div class="jp-hero">
        <div class="jp-hero-content">
            <div class="jp-hero-text-container">
                <h1 class="jp-hero-title">重要データを<br>素早く検索</h1>
                <p class="jp-hero-subtitle">
                    大量のデータを迅速かつ正確に<br>検索できるアプリ
                </p>
                <div class="jp-hero-buttons">
                    @guest
                        <a href="{{ route('login') }}" class="btn jp-btn jp-btn-primary me-3">
                            ログイン
                        </a>
                        <a href="{{ route('register') }}" class="btn jp-btn jp-btn-outline">
                            新規登録
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn jp-btn jp-btn-primary me-3">
                            ダッシュボード
                        </a>
                        <a href="{{ route('search.index') }}" class="btn jp-btn jp-btn-outline">
                            検索を始める
                        </a>
                    @endguest
                </div>
            </div>
            <div class="jp-hero-pattern"></div>
        </div>
    </div>
    
    <div class="jp-features">
        <div class="container">
            <h2 class="jp-section-title text-center">主な特徴</h2>
            <div class="jp-divider-center">
                <div class="jp-divider-inner"></div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="jp-feature-card">
                        <div class="jp-feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="jp-feature-title">簡単アカウント作成</h3>
                        <p class="jp-feature-text">
                            数ステップで登録できる簡単なアカウント作成プロセス。
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="jp-feature-card">
                        <div class="jp-feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="jp-feature-title">効率的な検索</h3>
                        <p class="jp-feature-text">
                            キーワードやカテゴリから、必要な情報を素早く見つけることができます。
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="jp-feature-card">
                        <div class="jp-feature-icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <h3 class="jp-feature-title">和のデザイン</h3>
                        <p class="jp-feature-text">
                            日本の伝統的な美学を取り入れた、落ち着きのあるインターフェース。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="jp-cta-section">
        <div class="container">
            <div class="jp-cta-inner">
                <h2 class="jp-cta-title">今すぐ始めましょう</h2>
                <p class="jp-cta-text">
                    アカウントを作成して、日本スタイルのデータ検索アプリケーションをご利用ください。
                </p>
                <div class="jp-cta-button">
                    @guest
                        <a href="{{ route('register') }}" class="btn jp-btn jp-btn-primary jp-btn-lg">
                            無料で登録する
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn jp-btn jp-btn-primary jp-btn-lg">
                            ダッシュボードへ
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
