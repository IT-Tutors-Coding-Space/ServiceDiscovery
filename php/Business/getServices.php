<?php
require_once "../../php/db_connect.php";

$owner_id = $_SESSION["user_id"];
$query = "SELECT * FROM services WHERE owner_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

$listings = [];
while ($row = $result->fetch_assoc()) {
    $listings[] = $row;
}

echo json_encode($listings);
?>
