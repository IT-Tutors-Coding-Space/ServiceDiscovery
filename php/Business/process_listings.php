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

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

// Check if the business ID exists in the session
if (!isset($_SESSION['business_id']) || empty($_SESSION['business_id'])) {
    // Fetch business_id dynamically
    $query = $conn->prepare("SELECT id FROM businesses WHERE owner_id = ?");
    $query->execute([$_SESSION['id']]);
    $business_id = $query->fetchColumn();

    if ($business_id) {
        $_SESSION['business_id'] = (int) $business_id; // Store in session
    } else {
        die("Error: Business not found for this owner.");
    }
}

$owner_id = $_SESSION['business_id']; // Now it's safe to use

// Validate form inputs
$sname = trim($_POST['listing-title'] ?? '');
$scategory = trim($_POST['listing-category'] ?? '');
$sprice = trim($_POST['listing-price'] ?? '');
$status = trim($_POST['listing-status'] ?? '');
$sdescription = trim($_POST['listing-description'] ?? '');

// Basic input validation
if (empty($sname) || empty($scategory) || empty($sprice) || empty($status) || empty($sdescription)) {
    die("Error: All fields are required.");
}

if (!is_numeric($sprice) || $sprice < 100) {
    die("Error: Invalid price.");
}

// Ensure business exists
$checkBusiness = $conn->prepare("SELECT id FROM businesses WHERE id = ?");
$checkBusiness->execute([$owner_id]);

if ($checkBusiness->rowCount() === 0) {
    die("Error: Invalid business ID.");
}

// Prepare SQL statement to insert service
$stmt = $conn->prepare("INSERT INTO services (owner_id, sname, scategory, sdescription, sprice, status, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())");

if ($stmt->execute([$owner_id, $sname, $scategory, $sdescription, $sprice, $status])) {
    echo "Listing added successfully!";
} else {
    die("Error: Unable to add listing.");
}
?>
