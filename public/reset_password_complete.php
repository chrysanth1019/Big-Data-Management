<?php
// Start session
session_start();

// Check if all required data is present
if (!isset($_POST['token']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
    header('Location: forgot_password.php?error=無効なリクエストです。');
    exit;
}

$token = $_POST['token'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['password_confirm'];

// Validate email
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
    header('Location: reset_password_form.php?error=有効なメールアドレスを入力してください。&token=' . urlencode($token) . '&email=' . urlencode($email));
    exit;
}

// Validate passwords
if (empty($password)) {
    header('Location: reset_password_form.php?error=パスワードを入力してください。&token=' . urlencode($token) . '&email=' . urlencode($email));
    exit;
}

if (strlen($password) < 8) {
    header('Location: reset_password_form.php?error=パスワードは8文字以上で入力してください。&token=' . urlencode($token) . '&email=' . urlencode($email));
    exit;
}

// Check password strength (you could add more complex validation here)
if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
    header('Location: reset_password_form.php?error=パスワードは英字、数字、記号を含める必要があります。&token=' . urlencode($token) . '&email=' . urlencode($email));
    exit;
}

// Check if passwords match
if ($password !== $passwordConfirm) {
    header('Location: reset_password_form.php?error=パスワードが一致しません。&token=' . urlencode($token) . '&email=' . urlencode($email));
    exit;
}

// In a real application, you'd verify the token in the database and reset the user's password
// For demo purposes, we'll just show a success page

// Normally, we would update the user's password in the database like:
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
// $stmt->execute([$hashedPassword, $email]);

// Redirect to success page
header('Location: password_reset_success.php');
exit;