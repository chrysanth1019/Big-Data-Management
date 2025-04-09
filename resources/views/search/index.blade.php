@extends('layouts.app')

@section('title', 'データ検索')

@section('content')
<div class="jp-search-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="jp-card">
                <div class="jp-card-header">
                    <h1 class="jp-title text-center">データ検索</h1>
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
                    
                    <form method="GET" action="{{ route('search.results') }}" id="searchForm">
                        <div class="mb-4">
                            <label for="query" class="form-label jp-label">検索キーワード</label>
                            <div class="jp-input-wrapper">
                                <input id="query" type="text" class="form-control jp-input @error('query') is-invalid @enderror" 
                                       name="query" value="{{ old('query') }}" required>
                            </div>
                            <small class="form-text jp-small-text">※ 2文字以上で入力してください</small>
                            @error('query')
                                <span class="jp-error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="category" class="form-label jp-label">カテゴリー（任意）</label>
                            <div class="jp-select-wrapper">
                                <select id="category" class="form-select jp-select" name="category">
                                    <option value="">すべてのカテゴリー</option>
                                    <option value="旅行" {{ old('category') == '旅行' ? 'selected' : '' }}>旅行</option>
                                    <option value="料理" {{ old('category') == '料理' ? 'selected' : '' }}>料理</option>
                                    <option value="文学" {{ old('category') == '文学' ? 'selected' : '' }}>文学</option>
                                    <option value="文化" {{ old('category') == '文化' ? 'selected' : '' }}>文化</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                <i class="fas fa-search me-2"></i>検索する
                            </button>
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
        const searchForm = document.getElementById('searchForm');
        
        if (searchForm) {
            searchForm.addEventListener('submit', function(event) {
                const query = document.getElementById('query').value;
                let isValid = true;
                
                // Clear previous error messages
                document.querySelectorAll('.jp-error-message').forEach(el => {
                    el.remove();
                });
                
                // Query validation
                if (!query || query.length < 2) {
                    isValid = false;
                    const queryInput = document.getElementById('query');
                    const errorMessage = document.createElement('span');
                    errorMessage.className = 'jp-error-message';
                    errorMessage.textContent = '検索キーワードは2文字以上で入力してください。';
                    queryInput.parentNode.after(errorMessage);
                }
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    });
</script>
@endsection
