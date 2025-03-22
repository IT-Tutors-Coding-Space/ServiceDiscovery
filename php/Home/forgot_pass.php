<?php
session_start();
require "conn.php"; // Database connection
require "send_mail.php"; // Include PHPMailer function

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));

        // Store token in database with expiry (1 hour)
        $stmt = $conn->prepare("UPDATE user SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->execute([$resetToken, $email]);

        // Send Reset Email
        $subject = "Password Reset Request";
        if (sendResetEmail($email, $resetToken, $subject)) {
            $_SESSION['success'] = "Reset email sent! Check your inbox.";
        } else {
            $_SESSION['error'] = "Failed to send reset email.";
        }
    } else {
        $_SESSION['error'] = "Email not found.";
    }

    header("Location: /ServiceDiscovery/pages/Home/forgot_pass.php");
    exit();
    
}
?>
