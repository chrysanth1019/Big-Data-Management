<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウントがブロックされています - データサービス</title>
    
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
            --jp-dark: #1A1A2E;
        }
        
        body {
            font-family: 'Noto Sans JP', sans-serif;
            color: #FFF;
            background: linear-gradient(135deg, #1A1A2E 0%, #16213E 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .blocked-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .blocked-card {
            background: linear-gradient(135deg, #252A3B 0%, #1E2033 100%);
            border-radius: 10px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .blocked-header {
            background: linear-gradient(90deg, #C62828 0%, #B71C1C 100%);
            padding: 1.5rem;
            position: relative;
        }
        
        .blocked-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.2);
            position: absolute;
            top: 1rem;
            right: 1.5rem;
        }
        
        .blocked-body {
            padding: 2rem;
        }
        
        .blocked-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #FFF;
            text-shadow: 0 0 10px rgba(198, 40, 40, 0.5);
        }
        
        .blocked-text {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.7;
        }
        
        .alert-box {
            background: rgba(198, 40, 40, 0.1);
            border-left: 4px solid #C62828;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }
        
        .info-alert {
            background: rgba(21, 101, 192, 0.1);
            border-left: 4px solid #1565C0;
        }
        
        .watermark {
            position: absolute;
            bottom: 1.5rem;
            right: 1.5rem;
            font-size: 4rem;
            opacity: 0.05;
            transform: rotate(-15deg);
        }
        
        @media (max-width: 768px) {
            .blocked-container {
                padding: 1rem;
            }
            
            .blocked-card {
                margin: 0 1rem;
            }
            
            .blocked-header {
                padding: 1rem;
            }
            
            .blocked-icon {
                font-size: 3rem;
                top: 0.5rem;
                right: 1rem;
            }
            
            .blocked-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="blocked-card">
            <div class="blocked-header">
                <h1 class="h3 text-white mb-0">セキュリティ通知</h1>
                <div class="blocked-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
            </div>
            
            <div class="blocked-body">
                <h2 class="blocked-title">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    アカウントがブロックされています
                </h2>
                
                <div class="alert-box">
                    <p class="mb-0">
                        <i class="bi bi-shield-exclamation me-2"></i>
                        セキュリティ上の理由により、現在このアカウントへのアクセスは制限されています。
                    </p>
                </div>
                
                <p class="blocked-text">
                    お客様のアカウントは管理者によってブロックされました。
                </p>
                
                <div class="alert-box info-alert mb-4">
                    <p class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>注意:</strong> アカウントのブロック/ブロック解除は管理者のみが行えます。
                    </p>
                </div>
                
                <p class="blocked-text">
                    アカウントのブロックを解除するには管理者にお問い合わせください。
                </p>
                
                <div class="d-flex justify-content-end">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light px-4">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            ログアウト
                        </button>
                    </form>
                </div>
                
                <div class="watermark">
                    <i class="bi bi-lock-fill"></i>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <small class="text-white-50">
            </small>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>