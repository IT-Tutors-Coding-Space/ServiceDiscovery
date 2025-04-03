<?php
require_once "../../php/session_handler.php";
require_once "../../php/conn.php";

if (!isCustomer()) {
    header("Location: /ServiceDiscovery/Customer/add_request.php?message=Unauthorized request.");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $budget = isset($_POST['budget']) && $_POST['budget'] !== "" ? $_POST['budget'] : NULL;

    // Ensure required fields are not empty
    if (empty($title) || empty($description) || empty($category)) {
        header("Location: /ServiceDiscovery/Customer/add_request.php?message=All fields except budget are required.");
        exit();
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO service_requests (user_id, title, description, category, budget, created_at) VALUES (?, ?, ?, ?, ?, NOW())");

    if ($stmt->execute([$user_id, $title, $description, $category, $budget])) {
        header("Location: /ServiceDiscovery/pages/Customer/index.php?message=Service request posted successfully!");
        exit();
    } else {
        header("Location: /ServiceDiscovery/pages/Customer/index.php?message=Error posting request.");
        exit();
    }
} else {
    header("Location: /ServiceDiscovery/pages/Customer/index.php?message=Invalid request method.");
    exit();
}
