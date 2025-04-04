<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: /ServiceDiscovery/pages/Home/login.php?message=Please log in to order.");
    exit;
}

// Process the order if the user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["service_id"])) {
    $service_id = $_POST["service_id"];

    // Redirect to the order confirmation page
    header("Location: confirm_order.php?service_id=" . $service_id);
    exit;
}

// If no service ID is provided, redirect back
header("Location: /ServiceDiscovery/pages/Home/index.html");
exit;
?>
