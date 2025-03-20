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

    $_SESSION['error'] = "";

    if (!in_array($role, $allowed_roles)) {
        $_SESSION['error'] = "Invalid role.";
    }
    // Check if all fields are required
   elseif (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
       $_SESSION['error'] = "All fields are required.";
    }
    // Validate email format
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $_SESSION['error'] = "Invalid email format.";
    }
    // Validate username length
    elseif (strlen($username) < 3 || strlen($username) > 50) {
       $_SESSION['error'] = "Username must be between 3 and 50 characters.";
    }
    // Validate passwords match
    elseif ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
    } else{
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email is already in use";
    } else{

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