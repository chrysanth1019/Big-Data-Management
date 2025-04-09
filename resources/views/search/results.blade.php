@extends('layouts.app')

@section('title', '検索結果')

@section('content')
<div class="jp-results-container">
    <div class="row">
        <div class="col-12">
            <div class="jp-card">
                <div class="jp-card-header">
                    <h1 class="jp-title">検索結果</h1>
                    <div class="jp-divider">
                        <div class="jp-divider-inner"></div>
                    </div>
                    <p class="jp-search-summary">
                        <span class="fw-bold">「{{ $query }}」</span>の検索結果
                        @if($category)
                            <span class="jp-category-badge">{{ $category }}</span>
                        @endif
                    </p>
                </div>
                
                <div class="jp-card-body">
                    @if(count($results) > 0)
                        <div class="jp-results-list">
                            @foreach($results as $result)
                                <div class="jp-result-item">
                                    <div class="jp-result-header">
                                        <h3 class="jp-result-title">{{ $result['title'] }}</h3>
                                        <span class="jp-category-badge">{{ $result['category'] }}</span>
                                    </div>
                                    <p class="jp-result-description">{{ $result['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="jp-no-results">
                            <div class="jp-no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="jp-no-results-title">検索結果がありません</h3>
                            <p class="jp-no-results-text">
                                「{{ $query }}」に一致する結果は見つかりませんでした。<br>
                                別のキーワードで検索してみてください。
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('search.index') }}" class="btn jp-btn jp-btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>検索画面に戻る
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            @if(count($results) > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('search.index') }}" class="btn jp-btn jp-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>検索画面に戻る
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
