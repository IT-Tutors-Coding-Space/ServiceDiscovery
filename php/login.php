<?php
//start the session
session_start();

 // Include the session handler
require 'session_handler.php';
require 'conn.php'; // Ensure you have a proper database connection


if (session_status() !== PHP_SESSION_NONE) {
    session_regenerate_id(true); // Secure session handling
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $role = htmlspecialchars(trim($_POST['role']), ENT_QUOTES, 'UTF-8');

    // Validate input
    if (empty($email) || empty($password) || empty($role)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location:" . BASE_PATH ."Home/login.php");
        exit();
    }

    // Validate role
    $allowed_roles = ["Customer", "Business Owner"];
    if (!in_array($role, $allowed_roles)) {
        $_SESSION['error'] = "Invalid role selected.";
        header("Location: " . BASE_PATH . "Home/login.php");
        exit();
    }

    try {
        // Prepare and execute SQL query
        $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ? AND role = ?");
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user

        // Check if user exists and verify password
        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            // Secure session storage
            $_SESSION['id'] = (int) $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === "Customer") {
                header("Location:" . BASE_PATH . "Customer/profile.php");
            } elseif ($user['role'] === "Business Owner") {
                header("Location: " . BASE_PATH . "Dashboard/business_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect email or password.";
            error_log("Login failed for email: $email due to Incorrect credentials or role mismatch.");
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage()); // Log error for debugging
        $_SESSION['error'] = "An error occurred. Please try again later.";
    }

    // Redirect back to login page if login fails
    header("Location:" . BASE_PATH . "Home/login.php");
    exit();
}
?>
