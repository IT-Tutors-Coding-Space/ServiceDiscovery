<?php
require_once "db.php";
require_once "session_handler.php";

if (!isBusinessOwner()) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$owner_id = $_SESSION['id'];
$sql = "SELECT * FROM Services WHERE owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
$services = [];

while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}

echo json_encode(["success" => true, "services" => $services]);
?>
