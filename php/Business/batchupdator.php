<?php
require_once "/ServiceDiscovery/php/conn.php";
require_once "/ServiceDiscovery/php/session_handler.php";

if (!isBusinessOwner()) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$owner_id = $_SESSION['id'];

// Validate input
if (!isset($data['action'], $data['ids']) || !is_array($data['ids'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit();
}

$ids = array_map('intval', $data['ids']);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$params = $ids;
array_unshift($params, $owner_id);

try {
    $conn->begin_transaction();
    
    switch ($data['action']) {
        case 'activate':
            $sql = "UPDATE services SET status = 'active' 
                    WHERE owner_id = ? AND id IN ($placeholders)";
            break;
        case 'deactivate':
            $sql = "UPDATE services SET status = 'inactive' 
                    WHERE owner_id = ? AND id IN ($placeholders)";
            break;
        case 'delete':
            $sql = "DELETE FROM services 
                    WHERE owner_id = ? AND id IN ($placeholders)";
            break;
        default:
            throw new Exception("Invalid action");
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($params)), ...$params);
    $stmt->execute();
    
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Batch operation completed"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>