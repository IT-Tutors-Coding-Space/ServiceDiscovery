<?php
require_once "../../php/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $listing_id = intval($_POST["id"]);
    $owner_id = $_SESSION["user_id"];

    $stmt = $conn->prepare("DELETE FROM services WHERE id = ? AND owner_id = ?");
    $stmt->bind_param("ii", $listing_id, $owner_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Listing deleted."]);
    } else {
        echo json_encode(["success" => false, "message" => "Deletion failed."]);
    }

    $stmt->close();
    $conn->close();
}
?>
