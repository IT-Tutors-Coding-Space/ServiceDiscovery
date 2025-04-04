<?php
require_once "../../php/session_handler.php";
require_once "../../php/conn.php";

if (!isCustomer()) {
    echo json_encode(["success" => false, "message" => "Unauthorized access"]);
    exit;
}

$user_id = $_SESSION['id'];
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

// Check if phone and address are provided
if (empty($phone) || empty($address)) {
    echo json_encode(["success" => false, "message" => "Please fill out all fields."]);
    exit;
}

// Update the database with the new values
$stmt = $conn->prepare("UPDATE customers SET phone = ?, address = ? WHERE user_id = ?");
$updated = $stmt->execute([$phone, $address, $user_id]);

if ($updated) {
    echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update profile. Try again later."]);
}
?>
