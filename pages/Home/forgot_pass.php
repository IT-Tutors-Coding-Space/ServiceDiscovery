<?php
session_start();
if (isset($_SESSION['error'])) {
    echo '<div class="popup-message error-message">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Clear the error message
}
if(isset($_SESSION['success'])){
    echo '<div class="popup-message success-message">'. $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/login.css">
</head>
<body>
    <h2>Forgot Password</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <form action="/ServiceDiscovery/php/forgot_pass.php" method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
