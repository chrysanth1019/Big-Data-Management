<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シンプル検索 - データサービス</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Shippori+Mincho:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --jp-red: #D40000;
            --jp-gold: #DAA520;
            --jp-navy: #223a70;
            --jp-blue: #4a6fa5;
            --jp-light-blue: #e6f0fa;
            --jp-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Noto Sans JP', sans-serif;
            color: #333;
            background-color: var(--jp-bg);
        }
        
        .container {
            max-width: 1140px;
        }
        
        /* Simple styles for the page */
        .page-header {
            padding: 2rem 0;
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .search-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            padding: 2rem;
        }
        
        /* Result card styling */
        .result-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .result-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .result-title {
            color: var(--jp-blue);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .result-tag {
            background-color: var(--jp-light-blue);
            border-radius: 4px;
            color: var(--jp-navy);
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        
        /* Table view styling */
        #table-view .table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        #table-view .table thead {
            background-color: var(--jp-navy);
            color: white;
        }
        
        #table-view .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        #table-view .table-hover tbody tr:hover {
            background-color: rgba(74, 111, 165, 0.1);
        }
        
        /* Pagination styling */
        .pagination .page-item.active .page-link {
            background-color: var(--jp-blue);
            border-color: var(--jp-blue);
        }
        
        .pagination .page-link {
            color: var(--jp-navy);
        }
        
        .pagination .page-link:hover {
            color: var(--jp-blue);
            background-color: #e9ecef;
        }
        
        /* Toggle buttons */
        .btn-check:checked + .btn-outline-primary {
            background-color: var(--jp-blue);
            border-color: var(--jp-blue);
        }
        
        .btn-primary {
            background-color: var(--jp-blue);
            border-color: var(--jp-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--jp-navy);
            border-color: var(--jp-navy);
        }
    </style>
</head>
<body>
    @include('partials.topbar')
    <main class="container mt-4">
        <form method="GET" action="{{ route('simple-search.index') }}" style="padding-bottom: 20px !important;">
            <!-- Accordion Wrapper -->
            <div class="accordion" id="searchAccordion">
                <!-- First Accordion Item (Search Criteria Section) -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        @if(isset($results) && request()->anyFilled(['query', 'category', 'date_from', 'date_to']))
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        @else
                        <button class="accordion-button" type="button" data-bs-toggle="" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        @endif
                            検索条件
                        </button>
                    </h2>
                    @if(isset($results) && request()->anyFilled(['query', 'category', 'date_from', 'date_to']))
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#searchAccordion">
                    @else
                    <div id="collapseOne" class="accordion-collapse" aria-labelledby="headingOne" data-bs-parent="#searchAccordion">
                    @endif
                        <div class="accordion-body">
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label for="query" class="form-label">キーワード検索</label>
                                    <input type="text" name="query" id="query" class="form-control" value="{{ request('query') }}" placeholder="検索したいキーワードを入力" require>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="category" class="form-label">カテゴリ</label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="0">全て</option>
                                        @foreach($categories as $e)
                                        <option value="{{ $e->id }}" {{ request('category') == $e->id ? 'selected' : '' }}>{{ $e->alias }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="date_from" class="form-label">日付 (開始)</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from', '1980-01-01') }}" require>
                                </div>
        
                                <div class="col-md-6">
                                    <label for="date_to" class="form-label">日付 (終了)</label>
                                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to', '2000-12-31') }}" require>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <!-- <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> リセット
                                </button> -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" style="width: 200px !important;">
                                        <i class="bi bi-search me-1"></i> 検索する
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        @if(isset($results) && request()->anyFilled(['query', 'category', 'date_from', 'date_to']))
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h3 class="mb-0">検索結果</h3>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>
                                50 件表示
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                100 件表示
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 200]) }}" {{ request('per_page') == 200 ? 'selected' : '' }}>
                                200 件表示
                            </option>
                        </select>
                    </div>
                </div>
                <div class="view-toggle d-flex align-items-center">
                    <span class="me-2">表示形式:</span>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="view-type" id="view-card" autocomplete="off" {{ request()->input("view") != "table" ? "checked" : "" }}>
                        <label class="btn btn-outline-primary btn-sm" for="view-card">
                            <i class="bi bi-grid-3x3-gap"></i> カード
                        </label>
                        
                        <input type="radio" class="btn-check" name="view-type" id="view-table" autocomplete="off" {{ request()->input("view") != "table" ? "" : "checked" }}>
                        <label class="btn btn-outline-primary btn-sm" for="view-table">
                            <i class="bi bi-table"></i> テーブル
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Server-side pagination is now handled by SimpleSearchController -->
            
            @if($results->count() > 0)
                <!-- Card View -->
                <div id="card-view" class="{{ request()->input('view') != 'table' ? '' : 'd-none' }}">
                    @foreach($results as $result)
                        <div class="result-card">
                            <div class="result-meta">
                                <span class="result-tag">
                                    <i class="bi bi-bookmark me-1"></i>
                                    {{ $result->category }}
                                </span>
                                <span class="result-tag">
                                    <i class="bi bi-file-earmark me-1"></i>
                                    {{ $result->type }}
                                </span>
                                <span class="result-tag">
                                    <i class="bi bi-building me-1"></i>{{ $result->publication }}
                                </span>
                                <span class="result-tag">
                                    <i class="bi bi-bookmark me-1"></i>第 {{ $result->issue }} 号
                                </span>
                            </div>
                            <p class="text-muted small">{{ $result->date }}</p>
                            <p>{!! Str::limit($result->content, 250, '...') !!}</p>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $loop->index }}">
                                <i class="bi bi-file-earmark-text me-1"></i> 詳細を見る
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" style="float: right;" onclick="downloadAsTxt('{{ $result->category }}',
                                '{{ $result->type }}', '{{ $result->publication }}', '{{ $result->issue }} 号', '{{ $result->date }}', '{{ json_encode($result->content) }}'
                                )">
                                <i class="bi bi-download me-1"></i> テキストとしてダウンロード
                            </button>
                        </div>
                    @endforeach
                </div>
                
                <!-- Table View -->
                <div id="table-view" class="{{ request()->input('view') != 'table' ? 'd-none' : '' }}">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">タイトル</th>
                                    <th scope="col">カテゴリ</th>
                                    <th scope="col">種類</th>
                                    <th scope="col">発行元</th>
                                    <th scope="col">発行日</th>
                                    <th scope="col">アクション</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                    <tr>
                                        <td width="50%"><p>{!! Str::limit($result->content, 150, '...') !!}</p></td>
                                        <td>
                                            <span class="badge bg-primary">{{ $result->category }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $result->type }}</span>
                                        </td>
                                        <td>                                            
                                            <span class="result-tag">{{ $result->publication }}</span>
                                        </td>
                                        <td>
                                            <span class="result-tag">{{ $result->date }}</span>                              
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $loop->index }}">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </button>
                                             <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadAsTxt('{{ $result->category }}',
                                                '{{ $result->type }}', '{{ $result->publication }}', '{{ $result->issue }} 号', '{{ $result->date }}', '{{ json_encode($result->content) }}'
                                                )"><i class="bi bi-download"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Detail Modals -->
                @foreach($results as $result)
                    <div class="modal fade" id="detailModal{{ $loop->index }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $loop->index }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="detailModalLabel{{ $loop->index }}"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <h5 class="modal-title me-3" id="detailModalLabel{{ $loop->index }}"></h5>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="downloadAsTxt('{{ $result->category }}',
                                            '{{ $result->type }}', '{{ $result->publication }}', '{{ $result->issue }} 号', '{{ $result->date }}', '{{ json_encode($result->content) }}'
                                            )">
                                            <i class="bi bi-download me-1"></i> テキストとしてダウンロード
                                        </button>
                                    </div>
                                    
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <div class="d-flex gap-2 mb-3">
                                            <span class="badge bg-primary">
                                                {{ $result->category }}
                                            </span>
                                            <span class="badge bg-secondary">{{ $result->type }}</span>
                                            <span class="badge bg-info text-dark">{{ $result->publication }}</span>
                                            <span class="badge bg-secondary">第 {{ $result->issue }} 号</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><strong>発行日:</strong> {{ $result->date }}</span>
                                            <span><strong>ID:</strong> {{ $result->id ?? $loop->iteration }}</span>
                                        </div>
                                    </div>
                                    
                                    <p>
                                        {!! nl2br(e($result->content)) !!}
                                    </p>
                                    
                                    <!-- <h6 class="fw-bold mb-3">キーポイント</h6>
                                    <ul>
                                        <li>{{ $result->category }}分野の最新動向について包括的な分析</li>
                                        <li>具体的なケーススタディを通じた実践的な適用例</li>
                                        <li>今後の展望と業界へのインパクト評価</li>
                                        <li>データに基づく客観的な評価と推奨</li>
                                    </ul> -->
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button> -->
                                    <button type="button" class="btn btn-primary" onclick="downloadAsTxt('{{ $result->category }}',
                                        '{{ $result->type }}', '{{ $result->publication }}', '{{ $result->issue }} 号', '{{ $result->date }}', '{{ json_encode($result->content) }}'
                                        )">
                                        <i class="bi bi-download me-1"></i> テキストとしてダウンロード
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination with Laravel's built-in pagination component -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="small text-muted">
                            {{ $results->total() }}件中 {{ ($results->currentPage() - 1) * $results->perPage() + 1 }}-{{ min($results->currentPage() * $results->perPage(), $results->total()) }}件を表示
                        </div>
                        <div>
                            <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href=this.value">
                                @for($i = 1; $i <= $results->lastPage(); $i++)
                                    <option value="{{ $results->url($i) }}" {{ $i == $results->currentPage() ? 'selected' : '' }}>
                                        {{ $i }}ページ目 / {{ $results->lastPage() }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <!-- Laravel's built-in pagination links with custom styling -->
                    <div class="d-flex justify-content-center">
                        {{ $results->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    検索条件に一致する結果が見つかりませんでした。検索条件を変更してお試しください。
                </div>
            @endif
        @endif
    </main>
    
    @include('partials.footer')
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // View toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const cardView = document.getElementById('card-view');
            const tableView = document.getElementById('table-view');
            const cardViewBtn = document.getElementById('view-card');
            const tableViewBtn = document.getElementById('view-table');
            
            if(cardViewBtn && tableViewBtn) {
                cardViewBtn.addEventListener('change', function() {
                    if (this.checked) {
                        const url = new URL(window.location.href);
                        const params = new URLSearchParams(url.search);
                        params.set('view', 'card');
                        url.search = params.toString();
                        window.location.href = url.toString();
                    }
                });
                
                tableViewBtn.addEventListener('change', function() {
                    if (this.checked) {
                        const url = new URL(window.location.href);
                        const params = new URLSearchParams(url.search);
                        params.set('view', 'table');
                        url.search = params.toString();
                        window.location.href = url.toString();
                    }
                });
            }
        });

        function downloadAsTxt(category, type, publication, issue, date, content) {
            // Create content for the text file
            const details = `
日付: ${date}
カテゴリ: ${category}
タイプ: ${type}
発行元: ${publication}
ダウンロード日時: ${new Date().toLocaleString('ja-JP')}

詳細内容:
${content}`;

            // Create a Blob object with the content
            const blob = new Blob([details], { type: 'text/plain;charset=utf-8' });
            
            // Create a downloadable link and trigger click
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            
            // Create filename from title and date
            const safeTitle = content.replace(/[\\/:*?"<>|]/g, '_').substring(0, 30); // Sanitize title and limit length
            const safeDate = date.replace(/[^0-9]/g, '');
            link.download = `${safeTitle}_${safeDate}.txt`;
            
            document.body.appendChild(link);
            link.click();
            
            // Clean up
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);
        }
    </script>
</body>
</html>
