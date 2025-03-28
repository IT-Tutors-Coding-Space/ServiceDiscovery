<?php
require_once "../../php/session_handler.php";
require_once "../../php/conn.php";

if (!isCustomer()) {
    exit("Unauthorized request.");
}

$user_id = $_SESSION['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$category = $_POST['category'];
$budget = $_POST['budget'] ?: NULL;

$stmt = $conn->prepare("INSERT INTO service_requests (user_id, title, description, category, budget) VALUES (?, ?, ?, ?, ?)");
if ($stmt->execute([$user_id, $title, $description, $category, $budget])) {
    echo "Service request posted successfully!";
} else {
    echo "Error posting request.";
}
?>
