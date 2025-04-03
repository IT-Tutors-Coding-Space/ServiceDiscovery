<?php
require_once "../../php/session_handler.php";

if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}

// Fetch customer details
$user_id = $_SESSION['id'];
require_once "../../php/conn.php";

$stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt1 = $conn->prepare("SELECT phone, address FROM customers WHERE user_id = ?");
$stmt1->execute([$user_id]);
$user1 = $stmt1->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">
<header>
    <h2>Profile</h2>
</header>

<section class="profile-container">
    <div class="profile-card">
        <div class="profile-pic">
            <img src="/ServiceDiscovery/Assets/images/profile1.jpg" alt="Profile Picture">
        </div>
        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

        <!-- Editable Fields -->
        <form method="POST" action="/ServiceDiscovery/php/Customer/update_profile.php">
            <p>Contact: 
                <span id="phone-text"><?php echo htmlspecialchars($user1['phone'] ?? 'N/A'); ?></span>
                <input type="text" name="phone" id="phone-input" value="<?php echo htmlspecialchars($user1['phone'] ?? ''); ?>" style="display:none;">
            </p>

            <p>Location: 
                <span id="address-text"><?php echo htmlspecialchars($user1['address'] ?? 'N/A'); ?></span>
                <input type="text" name="address" id="address-input" value="<?php echo htmlspecialchars($user1['address'] ?? ''); ?>" style="display:none;">
            </p>

            <div class="profile-actions">
                <button type="button" id="edit-profile-btn">Edit Profile</button>
                <button type="submit" id="save-profile-btn" style="display: none;">Save</button>
            </div>
        </form>
    </div>
</section>

<script>
        document.addEventListener("DOMContentLoaded", function () {
        const editBtn = document.getElementById("edit-profile-btn");
        const saveBtn = document.getElementById("save-profile-btn");
        
        const phoneText = document.getElementById("phone-text");
        const phoneInput = document.getElementById("phone-input");

        const addressText = document.getElementById("address-text");
        const addressInput = document.getElementById("address-input");

        // Show input fields and allow editing
        editBtn.addEventListener("click", function () {
            phoneText.classList.add("hidden");
            phoneInput.classList.remove("hidden");

            addressText.classList.add("hidden");
            addressInput.classList.remove("hidden");

            editBtn.classList.add("hidden");
            saveBtn.classList.remove("hidden");
        });
    });

</script>