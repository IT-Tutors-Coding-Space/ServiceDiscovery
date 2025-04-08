<?php
// Include the session handler and DB connection
require 'session_handler.php';
require 'conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize and trim input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $role_name = htmlspecialchars(trim($_POST['role']), ENT_QUOTES, 'UTF-8');

    // Validate input
    if (empty($email) || empty($password) || empty($role_name)) {
        $_SESSION['error'] = "All fields are required.";
        exit(); // Don't redirect from here if you're handling with JS frontend
    }

    try {
        // Get the role_id from roles table
        $role_stmt = $conn->prepare("SELECT id FROM roles WHERE name = ?");
        $role_stmt->execute([$role_name]);
        $role_id = $role_stmt->fetchColumn();

        if (!$role_id) {
            $_SESSION['error'] = "Invalid role selected.";
            exit();
        }

        // Get user matching email and role
        $stmt = $conn->prepare("SELECT id, email, password, role_id FROM users WHERE email = ? AND role_id = ?");
        $stmt->execute([$email, $role_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true); // Prevent session fixation

            // Store general user info in session
            $_SESSION['id'] = (int) $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role_name;
            $_SESSION['logged_in'] = true;

            // Handle Business Owner
            if ($role_name === "Business Owner") {
                $business_stmt = $conn->prepare("SELECT id FROM businesses WHERE owner_id = ?");
                $business_stmt->execute([$user['id']]);
                $business_id = $business_stmt->fetchColumn();

                // Store business_id (nullable)
                $_SESSION['business_id'] = $business_id ? (int) $business_id : null;
            }

            // Handle Customer
            if ($role_name === "Customer") {
                $customer_stmt = $conn->prepare("SELECT id FROM customer WHERE user_id = ?");
                $customer_stmt->execute([$user['id']]);
                $customer_id = $customer_stmt->fetchColumn();

                // Store customer_id (nullable)
                $_SESSION["customer_id"] = $customer_id ? (int) $customer_id : null;
            }

            // Redirect based on role
            if ($role_name === "Customer") {
                header("Location: /ServiceDiscovery/pages/Customer/index.php");
                exit();
            } elseif ($role_name === "Business Owner") {
                header("Location: /ServiceDiscovery/pages/Dashboard/index.php");
                exit();
            }

        } else {
            // Handle invalid login
            $_SESSION['error'] = "Incorrect email or password.";
            error_log("Login failed for email: $email due to incorrect credentials or role mismatch.");
        }

    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again later.";
    }

    // Redirect to login if failed
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}
?>
