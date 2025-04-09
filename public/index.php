<?php
/**
 * Japanese-styled Web Application
 * Simple front controller
 */

// Direct to welcome page for the root URL
if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php') {
    include 'welcome.php';
    exit;
}

// Check if the requested file exists and is a PHP file
$requestPath = $_SERVER['REQUEST_URI'];
$cleanPath = parse_url($requestPath, PHP_URL_PATH);
$filePath = __DIR__ . $cleanPath;

// If it's a PHP file and exists, include it
if (file_exists($filePath) && is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) == 'php') {
    include $filePath;
    exit;
}

// If we reach here, the requested resource wasn't found
header("HTTP/1.0 404 Not Found");
echo "<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - ページが見つかりません</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap' rel='stylesheet'>
    <link href='css/japanese-style.css' rel='stylesheet'>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #F6F5EC;
            font-family: 'Noto Sans JP', sans-serif;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-family: 'Noto Serif JP', serif;
            color: #D05A6E;
            margin-bottom: 20px;
            font-size: 28px;
        }
        p {
            color: #707C74;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #D05A6E;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #b84d5e;
            color: white;
        }
    </style>
</head>
<body>
    <div class='error-container'>
        <h1>404 - ページが見つかりません</h1>
        <p>お探しのページは見つかりませんでした。URLが正しいかご確認ください。</p>
        <a href='/' class='btn'>トップページに戻る</a>
    </div>
</body>
</html>";
exit;