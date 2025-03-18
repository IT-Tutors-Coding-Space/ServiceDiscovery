
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

      <?php if (isset($_GET['error'])): ?>
          <p class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
      <?php endif; ?>
      
        <form action="http://localhost/ServiceDiscovery/php/login.php" method="POST">
          <label for="email">Email</label>
          <input type="text" id="email" name="email" placeholder="Email Address" required>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your Password" required>
          <label for="role">Role</label>
          <select id="role" name="role">
            <option value="Customer">Customer</option>
            <option value="Business Owner">Business Owner</option>
          </select>

          <div class="remember-forgot">
            <a href="#">Forgot Password?</a>
          </div>

          <button type="submit" class="submitbtn">Sign In</button>
        </form>

        <p class="signup-text">Don't have an account? <a href="/ServiceDiscovery/pages/Home/signup.php">Sign Up</a></p>
      </div>
    </div>
  </div>
  <script src="/ServiceDiscovery/Assets/js/login.js"></script>
</body>
</html>
