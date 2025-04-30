<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IP制限 (IP Restricted)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .header {
            background-color: #b71c1c; /* Japanese red */
            color: white;
            padding: 20px;
        }
        .content {
            padding: 30px;
        }
        .ip-display {
            background: #f8f8f8;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            background-color: #b71c1c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #9a0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ IP制限 (IP Restricted)</h1>
        </div>
        <div class="content">
            <h2>このIPアドレスからのアクセスは許可されていません</h2>
            <p>この IP アドレスではこのページにアクセスできません。</p>
            
            <div class="ip-display">
                {{ $ip ?? 'Unknown IP' }}
            </div>
            
            <a href="{{ route('welcome') }}" class="btn">
                ホームに戻る
            </a>
        </div>
    </div>
</body>
</html>