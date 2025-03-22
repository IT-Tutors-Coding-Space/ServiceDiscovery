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
    <title>Discovery</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
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
                <a href="#" data-page="profile" onclick="navigateTo('profile')" style="color:black">👤 Profile</a>
                <a href="#" onclick="logout()" style="color:red">↻ Logout</a>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <ul>
            <li><a href="#" data-page="business_dashboard"><i class="fas fa-home"></i> <span class="text">Dashboard</span></a></li>
            <li><a href="#" data-page="settings"><i class="fas fa-cog"></i> <span class="text">Settings</span></a></li>
            <li><a href="#" data-page="manage_listings"><i class="fas fa-list"></i> <span class="text">Manage Listings</span></a></li>
            <li><a href="#" data-page="messages"><i class="fas fa-envelope"></i> <span class="text">Messages</span></a></li>            
        </ul>

    </aside>

    <!-- Main Content -->
    <section class="main-content" id="content">

     

    </section>

    <script src="/ServiceDiscovery/Assets/js/business.js"></script>
</body>
</html>
