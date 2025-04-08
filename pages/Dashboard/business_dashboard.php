<?php
require_once "../../php/session_handler.php";
require_once "../../php/conn.php"; // Include the connection file

// Ensure that the user is logged in as a business owner
if (!isBusinessOwner()) {
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}

// Check if the business owner ID is set in the session
if (!isset($_SESSION['business_id'])) {
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}

$business_owner_id = $_SESSION['business_id']; // Use the business ID stored in the session

// Query to get services data for the logged-in business owner
$sql = "SELECT sname, status, created_at FROM services WHERE owner_id = :business_owner_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':business_owner_id', $business_owner_id, PDO::PARAM_INT);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Requests | ServiceDiscovery</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">
</head>
<body>
    <!-- Dashboard Header -->
    <header class="dashboard-header">
        <div class="header-left">
            <h1>Business Dashboard</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <section class="requests-list">
            <div class="section-header">
                <h2>Your Services</h2>
            </div>
            
            <div class="table-container">
                <table class="listings-table" border="1">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requests)): ?>
                            <?php foreach ($requests as $request): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($request['sname']); ?></td>
                                    <td><?php echo htmlspecialchars($request['status']); ?></td>
                                    <td><?php echo htmlspecialchars($request['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No services yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="/ServiceDiscovery/Assets/js/business.js"></script>
</body>
</html>
