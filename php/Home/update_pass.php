<?php
session_start();
require 'conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verify token
    $stmt = $conn->prepare("SELECT id FROM user WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['message'] = "Invalid or expired token.";
        header("Location: forgot_password.php");
        exit();
    }

    // Update password
    $stmt = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
    $stmt->execute([$password, $user['id']]);

    $_SESSION['message'] = "Password reset successful. You can now log in.";
    header("Location: login.php");
    exit();
}
?>
