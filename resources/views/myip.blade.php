<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>あなたのIP (Your IP Address)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            padding: 30px;
        }
        .container {
            max-width: 850px;
            margin: 0 auto;
        }
        .ip-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 30px;
        }
        .header {
            background-color: #28a745; /* Success green */
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .ip-display {
            background: #f0fff0; /* Very light green */
            border: 1px solid #c3e6cb; /* Light green border */
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 24px;
            text-align: center;
            color: #155724; /* Dark green text */
        }
        .btn-jp {
            background-color: #28a745; /* Success green */
            color: white;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            border: none;
        }
        .btn-jp:hover {
            background-color: #218838; /* Darker green */
            color: white;
        }
        .copy-btn {
            margin-top: 10px;
        }
        .table {
            margin-top: 20px;
        }
        .success-message {
            display: none;
            color: #198754;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-globe"></i> IPアドレスを取得する </h1>
        </div>
        
        <div class="ip-card">
            <h2 class="text-center mb-4">現在のIPアドレス</h2>
            
            <div class="ip-display" id="ip-address">
                {{ $ip }}
            </div>
            
            <div class="text-center">
                <button class="btn btn-jp copy-btn" onclick="copyIpToClipboard()">
                    <i class="bi bi-clipboard"></i> IPアドレスをコピー
                </button>
                <div class="success-message" id="copy-success">
                    <i class="bi bi-check-circle"></i> コピーしました！
                </div>
            </div>
            
            <p class="mt-4 mb-3 text-center">
                このIPアドレスは、あなたがインターネットに接続する際に使用されている識別子です
            </p>
            
            <div class="row mt-4">
                <div class="col-md-6 offset-md-3">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('simple-search.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-search me-1"></i> 検索ページへ
                        </a>
                        <a href="{{ route('myip') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise"></i> 更新
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($city) || !empty($region) || !empty($country) || !empty($loc) || !empty($org) || !empty($postal) || !empty($timezone))
        <div class="ip-card mt-4">
            <h3 class="mb-3">詳細情報</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        @if(!empty($city))
                            <tr>
                                <td>city</td>
                                <td>{{ $city }}</td>
                            </tr>
                        @endif

                        @if(!empty($region))
                            <tr>
                                <td>region</td>
                                <td>{{ $region }}</td>
                            </tr>
                        @endif

                        @if(!empty($country))
                            <tr>
                                <td>country</td>
                                <td>{{ $country }}</td>
                            </tr>
                        @endif

                        @if(!empty($loc))
                            <tr>
                                <td>loc</td>
                                <td>{{ $loc }}</td>
                            </tr>
                        @endif

                        @if(!empty($org))
                            <tr>
                                <td>org</td>
                                <td>{{ $org }}</td>
                            </tr>
                        @endif

                        @if(!empty($postal))
                            <tr>
                                <td>postal</td>
                                <td>{{ $postal }}</td>
                            </tr>
                        @endif

                        @if(!empty($timezone))
                            <tr>
                                <td>timezone</td>
                                <td>{{ $timezone }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    
    <script>
        function copyIpToClipboard() {
            const ipElement = document.getElementById('ip-address');
            const successMsg = document.getElementById('copy-success');
            
            // Create a temporary input element
            const tempInput = document.createElement('input');
            tempInput.value = ipElement.innerText.trim();
            document.body.appendChild(tempInput);
            
            // Select and copy the text
            tempInput.select();
            document.execCommand('copy');
            
            // Remove the temporary input
            document.body.removeChild(tempInput);
            
            // Show success message
            successMsg.style.display = 'block';
            
            // Hide success message after 2 seconds
            setTimeout(() => {
                successMsg.style.display = 'none';
            }, 2000);
        }
    </script>
</body>
</html>