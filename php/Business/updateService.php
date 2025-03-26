<?php
require_once "/ServiceDiscovery/php/conn.php";
require_once "/ServiceDiscovery/php/session_handler.php";

if (!isBusinessOwner()) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'], $data['sname'], $data['scategory'], $data['sdescription'], $data['sprice'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit();
}

$owner_id = $_SESSION['id'];
$service_id = intval($data['id']);
$sname = trim($data['sname']);
$scategory = trim($data['scategory']);
$sdescription = trim($data['sdescription']);
$sprice = floatval($data['sprice']);

$sql = "UPDATE Services SET sname = ?, scategory = ?, sdescription = ?, sprice = ? WHERE id = ? AND owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdi", $sname, $scategory, $sdescription, $sprice, $service_id, $owner_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Service updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating service"]);
}
?>
