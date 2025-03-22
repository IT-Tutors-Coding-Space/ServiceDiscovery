<?php
session_start();
require '/php/conn.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM services WHERE id = ? AND business_id = ?");
$stmt->execute([$id, $_SESSION['id']]);

echo json_encode(["success" => "Service deleted"]);
?>
