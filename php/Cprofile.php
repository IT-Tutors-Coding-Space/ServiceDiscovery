<?php
require 'session_handler.php';
session_start();
if(session_status() == PHP_SESSION_NONE){
    session_regenerate_id(true);
}
require 'conn.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized access. Please log in."]);
    exit();
}

try {
    $userId = (int) $_SESSION['id'];
    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user); // Return user data as JSON
    } else {
        echo json_encode(["error" => "User not found."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "An error occurred. Please try again later."]);
}
?>
