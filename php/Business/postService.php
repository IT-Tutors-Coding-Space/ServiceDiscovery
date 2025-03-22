<?php
require_once "db.php";
require_once "session_handler.php";

if (!isBusinessOwner()) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['sname'], $data['scategory'], $data['sdescription'], $data['sprice'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit();
}

$owner_id = $_SESSION['id'];
$sname = trim($data['sname']);
$scategory = trim($data['scategory']);
$sdescription = trim($data['sdescription']);
$sprice = floatval($data['sprice']);

$sql = "INSERT INTO Services (owner_id, sname, scategory, sdescription, sprice, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssd", $owner_id, $sname, $scategory, $sdescription, $sprice);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Service added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error adding service"]);
}
?>
