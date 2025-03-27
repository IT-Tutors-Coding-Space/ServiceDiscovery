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
    <title>Messages</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">

</head>
<body>
<header class="dashboard-header">
        <div class="header-left">
            <h1>Messages Page</h1>
        </div>
    </header>
    <div class="main-content">

    </div>
</body>
</html>