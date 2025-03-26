<?php
require_once "/ServiceDiscovery/php/conn.php";
require_once "/ServiceDiscovery/php/session_handler.php";

if (!isBusinessOwner()) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['sname'], $data['scategory'], $data['sdescription'], $data['sprice'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit();
}

$owner_id = $_SESSION['id'];
$sname = trim($data['sname']);
$scategory = trim($data['scategory']);
$sdescription = trim($data['sdescription']);
$sprice = floatval($data['sprice']);

// Check if this is an update or insert
if (isset($data['id'])) {
    // Update existing service
    $id = intval($data['id']);
    $sql = "UPDATE Services SET sname = ?, scategory = ?, sdescription = ?, sprice = ?, created_at = NOW() 
            WHERE id = ? AND owner_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $sname, $scategory, $sdescription, $sprice, $id, $owner_id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Service updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating service"]);
    }
} else {
    // Insert new service
    $sql = "INSERT INTO Services (owner_id, sname, scategory, sdescription, sprice, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssd", $owner_id, $sname, $scategory, $sdescription, $sprice);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Service added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error adding service"]);
    }
}
?>
