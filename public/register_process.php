<?php
// Start session
session_start();

// Include reCAPTCHA verification function
require_once 'includes/recaptcha_verify.php';

// Simple registration process simulation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    
    // Input validation
    if (empty($name)) {
        header('Location: register.php?error=名前を入力してください。');
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: register.php?error=有効なメールアドレスを入力してください。');
        exit;
    }
    
    if (strlen($password) < 8) {
        header('Location: register.php?error=パスワードは8文字以上で入力してください。');
        exit;
    }
    
    if ($password !== $password_confirmation) {
        header('Location: register.php?error=パスワードが一致しません。');
        exit;
    }
    
    // Verify reCAPTCHA
    if (!verifyRecaptcha($recaptchaResponse)) {
        header('Location: register.php?error=セキュリティ確認に失敗しました。もう一度お試しください。');
        exit;
    }
    
    // In a real application, you would store in database and create a session
    // Redirect to dashboard on success
    header('Location: dashboard.php');
    exit;
} else {
    // If not POST request, redirect to registration page
    header('Location: register.php');
    exit;
}