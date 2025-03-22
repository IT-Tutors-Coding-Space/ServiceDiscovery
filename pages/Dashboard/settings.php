<?php
    require_once "../../php/session_handler.php";

    if (!isBusinessOwner()) {
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