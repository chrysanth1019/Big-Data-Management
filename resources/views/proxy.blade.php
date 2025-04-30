<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - プロキシ検出</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #f8f9fa;
            padding-top: 2rem;
        }
        .header {
            background-color: #b71c1c; /* Japanese red */
            padding: 1rem 0;
            color: white;
            margin-bottom: 2rem;
            text-align: center;
        }
        .header img {
            height: 40px;
        }
        .bg-japanese-red {
            background-color: #b71c1c;
        }
        .text-japanese-red {
            color: #b71c1c;
        }
        .border-japanese-red {
            border-color: #b71c1c !important;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h2><i class="fas fa-exclamation-triangle"></i> プロキシ検出 </h2>
        </div>
    </div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white text-center">
                    <h3 class="mb-0">アクセス制限</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h4 class="alert-heading">プロキシが検出されました</h4>
                        <p>セキュリティ上の理由から、プロキシを通したアクセスは許可されていません。直接接続してください。</p>
                    </div>

                    <div class="mt-4">
                        <h5>検出された情報 :</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="table-secondary">IP</th>
                                <td>{{ $ip ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th class="table-secondary" width="120px">User Agent</th>
                                <td>{{ $user_agent ?? 'Unknown' }}</td>
                            </tr>
                        </table>

                        @if(!empty($proxyInfo['headers']))
                        <h6 class="mt-3">プロキシヘッダ :</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ヘッダー (Header)</th>
                                        <th>値 (Value)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proxyInfo['headers'] as $header => $value)
                                    <tr>
                                        <td>{{ $header }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('welcome') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> ホームに戻る 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>