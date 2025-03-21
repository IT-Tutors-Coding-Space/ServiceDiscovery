<?php
session_start();
require 'conn.php';

if (isset($_SESSION['id'])) {
    $sessionId = session_id();

    $stmt = $conn->prepare("DELETE FROM session WHERE session_id = ?");
    $stmt->execute([$sessionId]);
}

session_unset();
session_destroy();

echo json_encode(["success" => true]);
exit();

?>