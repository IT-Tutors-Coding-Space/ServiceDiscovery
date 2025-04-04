<?php
    require_once "../../php/session_handler.php";

    if (!isBusinessOwner()) {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discovery</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="/ServiceDiscovery/Assets/images/hero-bg.png">
</head>
<body>
    <div class="head">
        <div class="header">
            <button id="menu-toggle" class="menu-btn">&#9776;</button>
        </div>
        <!-- Profile Dropdown -->
        <div class="profile-container">
            <button class="profile-btn" id="profile-btn">
                <p>Hi</p>
                <img src="/ServiceDiscovery/Assets/images/profile1.jpg" alt="User Avatar" id="user-avatar">
                <i class="fas fa-chevron-down"></i>
                
            </button>
            <div class="profile-dropdown" id="profile-dropdown">
                <a href="#" data-page="profile" style="color:blue">👤 Profile</a>
                <a href="#" onclick="event.preventDefault(); logout();" style="color:red">↻ Logout</a>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <ul>
            <li><a href="#" data-page="business_dashboard"><i class="fas fa-home"></i> <span class="text">Dashboard</span></a></li>
            <li><a href="#" data-page="settings"><i class="fas fa-cog"></i> <span class="text">Settings</span></a></li>
            <li><a href="#" data-page="manage_listings"><i class="fas fa-list"></i> <span class="text">Manage Listings</span></a></li>
            <li><a href="#" data-page="browse_request"><i class="fas fa-envelope"></i> <span class="text">Browse Requests</span></a></li>  
            <li><a href="#" data-page="messages"><i class="fas fa-cog"></i> <span class="text">Messages</span></a></li>
          
        </ul>

    </aside>

    <!-- Main Content -->
    <section class="main-content" id="content">

     

    </section>

    <script src="/ServiceDiscovery/Assets/js/business.js"></script>
    <script src="/ServiceDiscovery/Assets/js/manage_listings.js"></script>

</body>
</html>
