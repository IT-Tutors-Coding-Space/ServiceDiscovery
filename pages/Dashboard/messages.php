<?php
    require_once "../../php/session_handler.php";
    require_once "../../php/conn.php";

    if (!isBusinessOwner()) {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }

    $businessId = $_SESSION['business_id']; // Assuming you store business ID here
    $stmt = $conn->prepare("SELECT business_name, location FROM businesses WHERE id = :id");
    $stmt->execute([':id' => $businessId]);
    $business = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $business['business_name'] ?? '';
    $location = $business['location'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">

</head>
<body>
<header class="dashboard-header">
        <div class="header-left">
            <h1>Edit Profile</h1>
        </div>
    </header>
    <div class="main-content">
        <!-- fields for editing the profile -->
         <!-- add business and location to the table business -->

         <form action="/ServiceDiscovery/php/Business/edit_profile.php" method="post">
                        <label for="name">Business Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($location) ?>" required>

            <button type="submit">Update Profile</button>

         </form>

    </div>
</body>
</html>