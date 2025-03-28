<?php
require_once "../../php/session_handler.php";

if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}

// Fetch customer details
$user_id = $_SESSION['id'];
require_once "../../php/conn.php";

$stmt = $conn->prepare("SELECT username, email, phone, address, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

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

<script src="/ServiceDiscovery/Assets/js/Cprofile.js"></script>
