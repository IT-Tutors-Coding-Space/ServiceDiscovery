<?php
// Database connection
require_once "../../php/conn.php";
session_start();

// Ensure valid database connection
if (!isset($conn) || !$conn instanceof PDO) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

// Ensure the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid rrequest."]);
    exit;
}

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$user_id = $_SESSION['id'];

// Check if the business ID exists in the session
if (!isset($_SESSION['business_id']) || empty($_SESSION['business_id'])) {
    // Fetch business_id dynamically
    $query = $conn->prepare("SELECT id FROM businesses WHERE owner_id = ?");
    $query->execute([$user_id]);
    $business_id = $query->fetchColumn();

    if (!$business_id) {
        echo json_encode(["status" => "error", "message" => "Business not found for this owner."]);
        exit;    
    }
    $_SESSION['business_id'] = (int) $business_id; //store in session
}

$business_id = $_SESSION['business_id']; // Now it's safe to use

// Validate and sanitize form inputs
$sname = trim($_POST['listing-title'] ?? '');
$scategory = trim($_POST['listing-category'] ?? '');
$sprice = trim($_POST['listing-price'] ?? '');
$status = trim($_POST['listing-status'] ?? '');
$sdescription = trim($_POST['listing-description'] ?? '');

// Basic input validation
if (empty($sname) || empty($scategory) || empty($sprice) || empty($status) || empty($sdescription)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

if (!is_numeric($sprice) || $sprice < 100) {
    echo json_encode(["status" => "error", "message" => "Invalid price. Minimum is 100"]);
    exit;
}

// Ensure business exists
$checkBusiness = $conn->prepare("SELECT id FROM businesses WHERE id = ?");
$checkBusiness->execute([$business_id]);

if ($checkBusiness->rowCount() === 0) {
    die("Error: Invalid business ID.");
}

// Prepare SQL statement to insert service
$stmt = $conn->prepare("INSERT INTO services (owner_id, sname, scategory, sdescription, sprice, status, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())");

if ($stmt->execute([$business_id, $sname, $scategory, $sdescription, $sprice, $status])) {
    echo json_encode(["status" => "success", "message" => "Listing added successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add listing. Please try again."]);
}
?>
