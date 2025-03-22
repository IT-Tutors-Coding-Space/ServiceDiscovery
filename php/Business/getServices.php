<?php
session_start();
require '/php/conn.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$business_id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT id, name, description FROM services WHERE business_id = ?");
$stmt->execute([$business_id]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($services);
?>
