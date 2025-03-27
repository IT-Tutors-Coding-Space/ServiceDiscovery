<?php
session_start();
require 'conn.php';
define("BASE_PATH" , "/ServiceDiscovery/pages/");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize input
    $username = trim(htmlspecialchars($_POST["username"])); // Sanitized username
    $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL)); // Sanitized email
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $role_name = htmlspecialchars(trim($_POST["role"]), ENT_QUOTES, 'UTF-8');

    $_SESSION['error'] = "";

    // Check if all fields are required
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($role_name)) {
        $_SESSION['error'] = "All fields are required.";
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
    }
    // Validate username length
    elseif (strlen($username) < 3 || strlen($username) > 50) {
        $_SESSION['error'] = "Username must be between 3 and 50 characters.";
    }
    // Validate passwords match
    elseif ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
    } else {
        // Retrieve role_id based on role name
        $role_stmt = $conn->prepare("SELECT id FROM roles WHERE name = ?");
        $role_stmt->execute([$role_name]);
        $role_id = $role_stmt->fetchColumn(); // Get role ID

        if (!$role_id) {
            $_SESSION['error'] = "Invalid role selected.";
        } else {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['error'] = "Email is already in use";
            } else {
                // Hash password for security
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Insert user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bindParam(1, $username, PDO::PARAM_STR);
                $stmt->bindParam(2, $email, PDO::PARAM_STR);
                $stmt->bindParam(3, $hashedPassword, PDO::PARAM_STR);
                $stmt->bindParam(4, $phone, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    $user_id = $conn->lastInsertId();

                    //insert to customer or businesses table
                    if($role_name == 'Customer'){
                        $stmt = $conn->prepare("INSERT INTO customers (user_id) VALUES (?)");
                        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
                        $stmt->execute();
                    }elseif($role_name == 'Business Owner'){
                        $stmt = $conn->prepare("INSERT INTO businesses (owner_id) VALUES (?)");
                        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                    
                    $_SESSION['success'] = "Registration successful! Please log in.";
                    header("Location: " . BASE_PATH . "Home/login.php");
                    exit();
                } else {
                    $_SESSION['error'] = "An error occurred. Please try again";
                    error_log("Database error:" . print_r($stmt->errorInfo(), true));
                }
            }
        }
    }
    header("Location: " . BASE_PATH . "Home/signup.php");
    exit();
}
?>