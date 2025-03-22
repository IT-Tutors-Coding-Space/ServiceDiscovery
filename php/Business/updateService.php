<?php
session_start();
require '/php/conn.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$stmt = $conn->prepare("UPDATE services SET name = ?, description = ? WHERE id = ? AND business_id = ?");
$stmt->execute([$name, $description, $id, $_SESSION['id']]);

echo json_encode(["success" => "Service updated"]);
?>
