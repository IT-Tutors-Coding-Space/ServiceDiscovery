<?php
require_once "../../php/session_handler.php";
require_once "../../php/conn.php"; // Include the connection file

// Ensure that the user is a business owner
if (!isBusinessOwner()) {
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}

// Fetch the business owner ID from the session
$business_owner_id = $_SESSION['user_id']; // Assuming this is stored in the session

// Query to get services data for the logged-in business owner
$sql = "SELECT sname, status, created_at FROM services WHERE owner_id = :business_owner_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':business_owner_id', $business_owner_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard | ServiceDiscovery</title>
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
        <!-- Left Column -->
        <div class="left-column">
            <!-- Business Listings -->
            <section class="business-listings">
                <div class="section-header">
                    <h2>Your Services</h2>
                </div>
                
                <div class="table-container">
                    <table class="listings-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody id="businessList">
                            <?php
                            // Check if any rows are returned
                            if ($result) {
                                // Loop through the result set and generate table rows
                                foreach ($result as $row) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['sname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                // If no services, show empty state message
                                echo "<tr id='empty-state'>
                                        <td colspan='3'>You haven't added any services yet.</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Right Column -->
        <div class="right-column"></div>
    </div>

    <script src="/ServiceDiscovery/Assets/js/business.js"></script>
</body>
</html>
