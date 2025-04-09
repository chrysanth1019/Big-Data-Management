<?php
// Start session
session_start();

// Include reCAPTCHA verification function
require_once 'includes/recaptcha_verify.php';

// Simple login process simulation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    
    // For demo purposes, any valid email and password with length >= 8 will work
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login.php?error=有効なメールアドレスを入力してください。');
        exit;
    }
    
    if (strlen($password) < 8) {
        header('Location: login.php?error=パスワードは8文字以上で入力してください。');
        exit;
    }
    
    // Verify reCAPTCHA
    if (!verifyRecaptcha($recaptchaResponse)) {
        header('Location: login.php?error=セキュリティ確認に失敗しました。もう一度お試しください。');
        exit;
    }
    
    // In a real application, you would validate against database
    // Redirect to dashboard on success
    header('Location: dashboard.php');
    exit;
} else {
    // If not POST request, redirect to login page
    header('Location: login.php');
    exit;
}