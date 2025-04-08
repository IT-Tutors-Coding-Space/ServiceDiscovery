<?php
    require_once "../../php/session_handler.php";
    
    if(isset($_GET['logout'])) {
        logout();
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">

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
            <div class="profile-dropdown" id="profile-dropdown">
                <a href="#" onclick="navigateTo('profile')" style="color:black">👤 Profile</a>
                <a href="/ServiceDiscovery/php/session_handler.php?logout=true" style="color:red">↻ Logout</a>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <ul>
            <li><a href="#" data-page="dashboard"><i class="fas fa-home"></i> <span class="text">Dashboard</span></a></li>
            <!-- <li><a href="#" data-page="profile"><i class="fas fa-user"></i> <span class="text">Profile</span></a></li> -->
            <li><a href="#" data-page="search"><i class="fas fa-search"></i> <span class="text">Search Services</span></a></li>
            <li><a href="#" data-page="add_request"><i class="fas fa-plus"></i> <span class="text">Add Request</span></a></li>
        </ul>
    </aside> 

    <!-- Main Content -->
    <section class="main-content" id="content">
        <!-- SPA Content Loads Here -->
    </section>

    <script src="/ServiceDiscovery/Assets/js/index.js"></script>
    <script>
        function searchServices() {
    const query = document.getElementById("search-box").value.trim();
    if (query.length < 2) {
        document.getElementById("search-results").innerHTML = "";
        return;
    }

    document.getElementById("loading").style.display = "block"; // Show loading

    fetch(`/ServiceDiscovery/php/search.php?q=${query}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("loading").style.display = "none"; // Hide loading
            let resultsDiv = document.getElementById("search-results");

            if (data.length === 0) {
                resultsDiv.innerHTML = "<p class='no-results'>No businesses found.</p>";
                return;
            }

            resultsDiv.innerHTML = data.map(business => 
                `<div class="business-card">
                    <h3>${business.name}</h3>
                    <p>Category: <strong>${business.category}</strong></p>
                    <a href="/ServiceDiscovery/pages/Dashboard/business_dashboard.php?id=${business.id}" class="view-profile">
                        View Profile →
                    </a>
                </div>`
            ).join('');
        })
        .catch(error => {
            document.getElementById("loading").style.display = "none";
            console.error("Search error:", error);
        });
}
    </script>
</body>
</html>
