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
                    <?php if (isset($_GET['error'])): ?>
                        <div class="jp-alert jp-alert-danger">
                            <ul class="mb-0">
                                <li><?php echo htmlspecialchars($_GET['error']); ?></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="GET" action="search_results.php" id="searchForm">
                        <div class="mb-4">
                            <label for="query" class="form-label jp-label">検索キーワード</label>
                            <div class="jp-input-wrapper">
                                <input id="query" type="text" class="form-control jp-input" 
                                    name="query" value="" required>
                            </div>
                            <small class="form-text jp-small-text">※ 2文字以上で入力してください</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="category" class="form-label jp-label">カテゴリー</label>
                                <div class="jp-select-wrapper">
                                    <select id="category" class="form-select jp-select" name="category">
                                        <option value="">すべてのカテゴリー</option>
                                        <option value="旅行">旅行</option>
                                        <option value="料理">料理</option>
                                        <option value="文学">文学</option>
                                        <option value="文化">文化</option>
                                        <option value="ニュース">ニュース</option>
                                        <option value="スポーツ">スポーツ</option>
                                        <option value="経済">経済</option>
                                        <option value="政治">政治</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <label for="type" class="form-label jp-label">種類</label>
                                <div class="jp-select-wrapper">
                                    <select id="type" class="form-select jp-select" name="type">
                                        <option value="">すべての種類</option>
                                        <option value="記事">記事</option>
                                        <option value="コラム">コラム</option>
                                        <option value="インタビュー">インタビュー</option>
                                        <option value="レビュー">レビュー</option>
                                        <option value="ガイド">ガイド</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <label for="publication" class="form-label jp-label">出版物</label>
                                <div class="jp-select-wrapper">
                                    <select id="publication" class="form-select jp-select" name="publication">
                                        <option value="">すべての出版物</option>
                                        <option value="日経新聞">日経新聞</option>
                                        <option value="朝日新聞">朝日新聞</option>
                                        <option value="読売新聞">読売新聞</option>
                                        <option value="毎日新聞">毎日新聞</option>
                                        <option value="産経新聞">産経新聞</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="issue_number" class="form-label jp-label">号数</label>
                            <div class="jp-input-wrapper">
                                <input id="issue_number" type="text" class="form-control jp-input" 
                                    name="issue_number" value="">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="content" class="form-label jp-label">内容</label>
                            <div class="jp-input-wrapper">
                                <input id="content" type="text" class="form-control jp-input" 
                                    name="content" value="">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="date_from" class="form-label jp-label">期間（開始日）</label>
                                <div class="jp-input-wrapper">
                                    <input id="date_from" type="date" class="form-control jp-input" 
                                        name="date_from" value="">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date_to" class="form-label jp-label">期間（終了日）</label>
                                <div class="jp-input-wrapper">
                                    <input id="date_to" type="date" class="form-control jp-input" 
                                        name="date_to" value="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label jp-label">表示形式</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="view_type" id="viewCard" value="card" checked>
                                    <label class="form-check-label" for="viewCard">
                                        <i class="fas fa-th-large me-1"></i> カード表示
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="view_type" id="viewTable" value="table">
                                    <label class="form-check-label" for="viewTable">
                                        <i class="fas fa-table me-1"></i> テーブル表示
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                <i class="fas fa-search me-2"></i>検索する
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('advanced_search') }}" class="jp-link">
                                <i class="fas fa-sliders-h me-1"></i> 詳細検索を利用する
                            </a>
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
        const viewCardRadio = document.getElementById('viewCard');
        const viewTableRadio = document.getElementById('viewTable');
        
        if (searchForm) {
            // Change the form action based on selected view type
            function updateFormAction() {
                if (viewTableRadio.checked) {
                    searchForm.action = 'table_search_results.php';
                } else {
                    searchForm.action = 'search_results.php';
                }
            }
            
            // Add event listeners to radio buttons
            viewCardRadio.addEventListener('change', updateFormAction);
            viewTableRadio.addEventListener('change', updateFormAction);
            
            // Set initial form action
            updateFormAction();
            
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
