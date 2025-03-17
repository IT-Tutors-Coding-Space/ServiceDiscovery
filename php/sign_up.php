<?php
session_start();
// Database connection
require "conn.php";

define('BASE_PATH', '/Service/pages/Home/'); // Define base path

function redirectWithError($error, $location) {
    $_SESSION['error'] = $error;
    header("Location: " . BASE_PATH . $location);
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
        redirectWithError("Invalid role.", "signup.html");
    }

    // Check if all fields are required
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        redirectWithError("All fields are required.", "signup.html");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithError("Invalid email format.", "signup.html");
    }

    // Validate username length
    if (strlen($username) < 3 || strlen($username) > 50) {
        redirectWithError("Username must be between 3 and 50 characters.", "signup.html");
    }

    // Validate passwords match
    if ($password !== $confirmPassword) {
        redirectWithError("Passwords do not match.", "signup.html");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        redirectWithError("Email is already in use.", "signup.html");
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
        header("Location: " . BASE_PATH . "login.html");
        exit();
    } else {
        error_log("Database error: " . print_r($stmt->errorInfo(), true)); // Log the error
        redirectWithError("An error occurred. Please try again.", "signup.html");
    }
}
?>