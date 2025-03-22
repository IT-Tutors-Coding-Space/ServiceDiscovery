<?php
    session_start();

    
    if (!isset($_SESSION["id"]) || $_SESSION["role"] !== "Customer") {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
             <div class="skeleton profile-pic"></div> 
            <h2 id="customer-name" class="skeleton-text"></h2>
            <p id="customer-email" class="skeleton-text"></p>
        </div>

        <div class="profile-details">
            <h3>Profile Information</h3>
            <p><strong>Contact:</strong> <span id="customer-phone" class="skeleton-text"></span></p>
            <p><strong>Location:</strong> <span id="customer-address" class="skeleton-text"></span></p>
        </div>

        <button id="edit-profile-btn">Edit Profile</button>
        <button id="search">Search</button>
        <button id="logout-btn">Logout</button>
    </div>

    <script src="/ServiceDiscovery/Assets/js/Cprofile.js"></script>
</body>
</html>
