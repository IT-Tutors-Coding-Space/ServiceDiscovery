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
    <title>Profile</title>
    
</head>
<body>
    <h1>Profile</h1>
    
</body>
</html>