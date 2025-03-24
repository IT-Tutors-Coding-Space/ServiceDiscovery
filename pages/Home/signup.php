<?php session_start(); 
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
    <title>Sign Up - Service Connect</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/styles.css">
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/signup.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div>SERVICE DISCOVERY</div>
        </div>

        <div class="right-side"> 
            <div class="signup-container">
                <img src="/ServiceDiscovery/Assets/images/hero-bg.png" alt="Logo" width="80">
                <h2>Create Your Account</h2>
                <p>Fill in your details to sign up</p>

                <!-- Display error message -->
                 <?php if(!isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                    <div id="error-message" class="error-message">
                        <?php echo $_SESSION['error']; ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>


                <form action="http://localhost/ServiceDiscovery/php/sign_up.php" method="POST">
                    <label for="username">User Name</label>
                    <input type="text" id="username" name="username" required>

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>

                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="Customer">Customer</option>
                        <option value="Business Owner">Business Owner</option>
                    </select>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>

                    <button type="submit" class="submitbtn">Sign Up</button>
                </form>

                <p class="login-text">Already have an account? <a href="/ServiceDiscovery/pages/Home/login.php">Log in</a></p>
            </div>
        </div>
    </div>

    <script src="/ServiceDiscovery/Assets/js/signup.js"></script>
    <script src="/ServiceDiscovery/Assets/js/login.js"></script>
</body>
</html>