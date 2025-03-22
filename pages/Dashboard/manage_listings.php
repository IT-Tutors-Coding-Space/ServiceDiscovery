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
    <title>Manage Listings</title>
    <link rel="stylesheet" href="/css/styles.css">
    <script src="/js/manage_listings.js" defer></script>
</head>
<body>

<h2>Manage Your Listings</h2>

<!-- Post New Service Form -->
<form id="postServiceForm">
    <input type="text" id="serviceName" placeholder="Service Name" required>
    <textarea id="serviceDescription" placeholder="Service Description" required></textarea>
    <button type="submit">Post Service</button>
</form>

<!-- Service Listings -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="servicesList">
        <!-- Services will be loaded here -->
    </tbody>
</table>

</body>
</html>