<?php
require_once "../../php/session_handler.php";

function isBusiness() {
    // Example implementation: Check if the user role is 'business'
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Business Owner';
}

if (!isBusiness()) {
    exit("<p>You must be logged in as a business.</p>");
}

require_once "../../php/conn.php";
$stmt = $conn->query("SELECT * FROM service_requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="requests-container">
    <h2>Available Service Requests</h2>
    <ul>
        <?php foreach ($requests as $request): ?>
            <li>
                <h3><?php echo htmlspecialchars($request['title']); ?></h3>
                <p><?php echo htmlspecialchars($request['description']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($request['category']); ?></p>
                <p><strong>Budget:</strong> <?php echo htmlspecialchars($request['budget'] ?? 'N/A'); ?></p>
                <button>Contact Customer</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
