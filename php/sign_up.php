<?php
session_start();
// Database connection
require "conn.php";
// Session handler
// require '/ServiceDiscovery/php/session_handler.php';

function redirectWithError($error, $location) {
    $_SESSION['error'] = $error;
    header("Location:  $location ");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize input
    $username = trim(htmlspecialchars($_POST["username"])); // Sanitized username
    $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL)); // Sanitized email
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $role = $_POST["role"];

    $allowed_roles = ["Customer", "Business Owner"];

    if (!in_array($role, $allowed_roles)) {
        redirectWithError("Invalid role.", BASE_PATH . "Home/signup.php");
    }

    // Check if all fields are required
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        redirectWithError("All fields are required.",BASE_PATH. "Home/signup.php");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithError("Invalid email format.",BASE_PATH. "Home/signup.php");
    }

    // Validate username length
    if (strlen($username) < 3 || strlen($username) > 50) {
        redirectWithError("Username must be between 3 and 50 characters.", BASE_PATH ."Home/signup.php");
    }

    // Validate passwords match
    if ($password !== $confirmPassword) {
        redirectWithError("Passwords do not match.",BASE_PATH. "Home/signup.php");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        redirectWithError("Email is already in use.",BASE_PATH. "Home/signup.php");
    }

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->bindParam(3, $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(4, $role, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: " . BASE_PATH . "Home/login.php");
        exit();
    } else {
        error_log("Database error: " . print_r($stmt->errorInfo(), true)); // Log the error
        redirectWithError("An error occurred. Please try again.",BASE_PATH. "Home/signup.php");
    }
}
?>