<?php
require_once "../../php/session_handler.php";

if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}
//fetch user id
$user_id = $_SESSION['id'];

//fetch recent service requests
$stmt = $conn->prepare("SELECT title, created_at FROM service_requests WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC)
?>
<link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">

<header class="dashboard-header">
    <h2>Welcome 👋</h2>
</header>

<section class="dashboard-container">


    <div class="dashboard-card">
        <h3>Notifications</h3>
        <p>You have <strong><span id="offers"> no</span> new offers</strong> on your requests.</p>
    </div>

    <div class="dashboard-card">
        <h3>Recent Activity</h3>
        <ul>
        <?php if (!empty($requests)): ?>
                <?php foreach ($requests as $request): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($request['title']); ?></strong>
                        <br>
                        <small>Posted on <?php echo date("F j, Y, g:i a", strtotime($request['created_at'])); ?></small>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No recent activity.</li>
            <?php endif; ?>
            
        </ul>
    </div>
</section>
