<?php
    require_once "../../php/session_handler.php";

    if (!isCustomer()) {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }

        // Fetch customer details from the session or database
        $user_id = $_SESSION['id'];
        require_once "../../php/conn.php";
    
        $stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">
    <link rel="icon" type="image/png" href="/ServiceDiscovery/Assets/images/hero-bg.png">
</head>
<body>

    <!-- Top Navigation -->
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
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <ul>
            <li><a href="#" data-page="customer_dashboard"><i class="fas fa-home"></i> <span class="text">Dashboard</span></a></li>
            <li><a href="#" data-page="profile"><i class="fas fa-user"></i> <span class="text">Profile</span></a></li>
            <li><a href="#" data-page="search_services"><i class="fas fa-search"></i> <span class="text">Search Services</span></a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <section class="main-content" id="content">
        <!-- SPA Content Loads Here -->
    </section>

    <script src="/ServiceDiscovery/Assets/js/business.js"></script>
</body>
</html>
