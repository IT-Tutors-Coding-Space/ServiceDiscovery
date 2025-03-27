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
    <title>Customer Profile</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">
</head>
<body>

<!-- Main Content -->
<div class="main-content">
    <header>
        <h2>Customer Profile</h2>
    </header>

    <section class="profile-container">
        <div class="profile-card">
            <div class="profile-pic">
                <img src="/ServiceDiscovery/Assets/images/profile1.jpg" alt="Profile Picture">
            </div>
            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Contact: <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
            <p>Location: <?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></p>
            
            <div class="profile-actions">
                <button id="edit-profile-btn">Edit Profile</button>
                <button id="search-services">Search Services</button>
            </div>
        </div>
    </section>
</div>

<script src="/ServiceDiscovery/Assets/js/profile.js"></script>
</body>
</html>
