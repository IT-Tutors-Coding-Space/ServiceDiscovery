<?php
require_once "../../php/session_handler.php";
if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");

    //fetch user id
    $user_id = $_SESSION['id'];
    require_once "../../php/conn.php";
}
?>
<link rel="stylesheet" href="/ServiceDiscovery/Assets/css/add_request.css">
<link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">

<div class="request-form">
    <h2>Post a Service Request</h2>
    
    <!-- Display messages from PHP -->
    <?php
    if (isset($_GET['message'])) {
        echo "<p id='request-message'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
    ?>
    
    <form id="service-request-form" action="/ServiceDiscovery/php/Customer/add_request.php" method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Describe your request" required></textarea>
        <input type="text" name="category" placeholder="Category" required>
        <input type="number" name="budget" placeholder="Budget (optional)">
        <button type="submit">Post Request</button>
    </form>
</div>
