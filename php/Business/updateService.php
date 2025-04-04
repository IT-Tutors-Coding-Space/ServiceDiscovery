<?php
require_once "../../php/db_connect.php"; // Ensure database connection

header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $category = trim($_POST["category"]);
    $price = floatval($_POST["price"]);
    $status = trim($_POST["status"]);
    $description = trim($_POST["description"]);
    $owner_id = $_SESSION["user_id"]; // Assuming business owners are logged in

    if (empty($title) || empty($category) || empty($price) || empty($status) || empty($description)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO services (title, category, price, status, description, owner_id) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("ssdssi", $title, $category, $price, $status, $description, $owner_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Listing saved successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
