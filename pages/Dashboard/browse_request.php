<?php
require_once "../../php/session_handler.php";

if (!isBusinessOwner()) {
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}

require_once "../../php/conn.php";
$stmt = $conn->query("SELECT * FROM service_requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">
    <h2 class="mb-4">Available Service Requests</h2>
    
    <div class="row">
        <?php foreach ($requests as $request): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($request['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($request['description']); ?></p>
                        <p class="card-text">
                            <strong>Category:</strong> <?php echo htmlspecialchars($request['category']); ?><br>
                            <strong>Budget:</strong> <?php echo htmlspecialchars($request['budget'] ?? 'N/A'); ?>
                        </p>
                        <a href="#" class="btn btn-primary">Contact Customer</a>
                    </div>
                    <div class="card-footer text-muted small">
                        Posted on <?php echo date("F j, Y", strtotime($request['created_at'])); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
