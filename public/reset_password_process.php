<?php
// Start session
session_start();

// Validate email
if (!isset($_POST['email']) || empty($_POST['email'])) {
    header('Location: forgot_password.php?error=メールアドレスを入力してください。');
    exit;
}

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
if (!$email) {
    header('Location: forgot_password.php?error=有効なメールアドレスを入力してください。');
    exit;
}

// In a real application, you'd check if the email exists in the database
// For demo purposes, we'll just simulate sending an email
$resetToken = bin2hex(random_bytes(32));

// Store the token in the database with the user's email and expiration time
// For now, we'll just display a success message as if the email was sent

// Normally we would email the user with a link like:
// $resetLink = "https://yourdomain.com/reset_password_form.php?token=$resetToken&email=$email";
// mail($email, 'パスワードリセット', "下記のリンクからパスワードをリセットしてください：\n$resetLink", 'From: support@yourdomain.com');

// Redirect to the forgot password page with a success message
header('Location: forgot_password.php?status=success');
exit;