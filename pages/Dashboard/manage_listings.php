<?php
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['role'] !== "Business Owner") {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Listings</title>
    <link rel="stylesheet" href="/Assets/css/Dashboard/listings.css">
</head>
<body>

<section class="manage-listings">
    <div class="listing-header">
        <h2>Manage Listings</h2>
        <button class="add-listing-btn" onclick="openAddListingModal()">+ Add Listing</button>
    </div>

    <input type="text" id="search-listings" placeholder="Search Listings..." oninput="filterListings()">
    
    <table class="listings-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="listings-body">
            <!-- Dynamic Data -->
        </tbody>
    </table>
</section>

</body>
<script src="/Assets/js/manage_listings.js"></script>

</html>