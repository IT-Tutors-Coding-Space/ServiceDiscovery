<?php
session_start();
require '/php/conn.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$business_id = $_SESSION['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$stmt = $conn->prepare("INSERT INTO services (business_id, name, description) VALUES (?, ?, ?)");
$stmt->execute([$business_id, $name, $description]);

echo json_encode(["success" => "Service posted"]);
?>
