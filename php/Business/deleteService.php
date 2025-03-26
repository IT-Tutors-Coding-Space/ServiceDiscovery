<?php
require_once "/ServiceDiscovery/php/conn.php";
require_once "/ServiceDiscovery/php/session_handler.php";

if (!isBusinessOwner()) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    echo json_encode(["success" => false, "message" => "Missing service ID"]);
    exit();
}

$owner_id = $_SESSION['id'];
$service_id = intval($data['id']);

$sql = "DELETE FROM Services WHERE id = ? AND owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $service_id, $owner_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Service deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error deleting service"]);
}
?>
