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
    <title>Document</title>
</head>
<body>
    <!-- system customization page -->
    <h2>Settings</h2>
</body>
</html>