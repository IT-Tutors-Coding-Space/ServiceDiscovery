<?php
// Database connection
require_once "../../php/conn.php";
session_start();

// Ensure valid database connection
if (!isset($conn) || !$conn instanceof PDO) {
    die("Database connection failed: Invalid connection object");
}

// Ensure the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method.");
}

// Check if the business owner is logged in
if (!isset($_SESSION['business_id'])) {
    echo "Error: Business not found";
    exit();
}

$owner_id = $_SESSION['business_id'];

// Validate form inputs
$sname = trim($_POST['listing-title'] ?? '');
$scategory = trim($_POST['listing-category'] ?? '');
$sprice = trim($_POST['listing-price'] ?? '');
$status = trim($_POST['listing-status'] ?? '');
$sdescription = trim($_POST['listing-description'] ?? '');

// Basic input validation
if (empty($sname) || empty($scategory) || empty($sprice) || empty($status) || empty($sdescription)) {
    echo "Error: All fields are required.";
    exit();
}

if (!is_numeric($sprice) || $sprice < 100) {
    echo "Error: Invalid price.";
    exit();
}

// Ensure business exists
$checkBusiness = $conn->prepare("SELECT id FROM businesses WHERE owner_id = ?");
$checkBusiness->execute([$owner_id]);

if ($checkBusiness->rowCount() === 0) {
    echo "Error: Invalid business ID";
    exit();
}

// Prepare SQL statement to insert service
$stmt = $conn->prepare("INSERT INTO services (owner_id, sname, scategory, sdescription, sprice, status, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())");

if ($stmt->execute([$owner_id, $sname, $scategory, $sdescription, $sprice, $status])) {
    echo "Listing added successfully!";
} else {
    echo "Error: Unable to add listing.";
}
?>
