<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Service Discovery</title>
  <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/styles.css">
  <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/login.css">
</head>
<body>
  <div class="container">
    <!-- Left Side (Image Section) -->
    <div class="left-side">
      <div>SERVICE DISCOVERY</div>
    </div>

    <!-- Right Side (Login Form) -->
    <div class="right-side">
      <div class="login-container">
        <img src="/ServiceDiscovery/Assets/images/hero-bg.png" alt="Logo" width="80">
        <h2>Hi, welcome back</h2>
        <p>Please fill in your details to log in</p>

        <!-- Error Message (if any) -->
        <?php if (isset($_SESSION['error'])): ?>
          <p id="error-message" class="error-message"><?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/ServiceDiscovery/php/login.php" method="POST">
          <label for="email">Email</label>
          <input type="text" id="email" name="email" placeholder="Email Address" required>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your Password" required >

          <label for="role">Role</label>
          <select id="role" name="role">
            <option value="Customer">Customer</option>
            <option value="Business Owner">Business Owner</option>
          </select>

          <div class="remember-forgot">
            <a href="/ServiceDiscovery/pages/Home/forgot_pass.php">Forgot Password?</a>
          </div>

          <button type="submit" class="submitbtn">Sign In</button>
        </form>

        <p class="signup-text">Don't have an account? <a href="/ServiceDiscovery/pages/Home/signup.php">Sign Up</a></p>
        <p class="home">
          <a href="/ServiceDiscovery/pages/Home/index.html">← Back to Home</a>
        </p>
      </div>
    </div>
  </div>
  <script src="/ServiceDiscovery/Assets/js/Alerts.js"></script>
</body>
</html>
