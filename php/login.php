<?php
 // Include the session handler
require 'session_handler.php';
require 'conn.php'; // Ensure you have a proper database connection


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();

    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $role_name = htmlspecialchars(trim($_POST['role']), ENT_QUOTES, 'UTF-8');

    // Validate input
    if (empty($email) || empty($password) || empty($role_name)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        
        exit();
    }



    try {
        // Retrieve role_id based on role name
        $role_stmt = $conn->prepare("SELECT id FROM roles WHERE name = ?");
        $role_stmt->execute([$role_name]);
        $role_id = $role_stmt->fetchColumn(); // Get role ID

        if(!$role_id) {
            $_SESSION['error'] = "Invalid role selected.";
            header("Location: /ServiceDiscovery/pages/Home/login.php");
            exit();
        }

        // Prepare and execute SQL query
        $stmt = $conn->prepare("SELECT id, email, password, role_id FROM users WHERE email = ? AND role_id = ?");
        $stmt->execute([$email, $role_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user

        // Check if user exists and verify password
        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            // Secure session storage
            $_SESSION['id'] = (int) $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role_name;


            // Redirect based on role
            if ($role_name === "Customer") {
                header("Location: /ServiceDiscovery/pages/Customer/profile.php");
                exit();
            } elseif ($role_name === "Business Owner") {
                header("Location:  /ServiceDiscovery/pages/Dashboard/index.php");
                exit();     
            }
            
        } else {
            $_SESSION['error'] = "Incorrect email or password.";
            error_log("Login failed for email: $email due to Incorrect credentials or role mismatch.");
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage()); // Log error for debugging
        $_SESSION['error'] = "An error occurred. Please try again later.";
    }

    // Redirect back to login page if login fails
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}
?>
