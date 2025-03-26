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
    <title>Business Dashboard | ServiceDiscovery</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css"> -->
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/business.css">
    <link rel="icon" type="image/png" href="/ServiceDiscovery/Assets/images/logo-icon.png">
</head>
<body>
    <!-- Dashboard Header -->
    <header class="dashboard-header">
        <div class="header-left">
            <h1>Business Dashboard</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Business Listings -->
            <section class="business-listings">
                <div class="section-header">
                    <h2>Your Services</h2>
                    <button class="add-service-btn" onclick="">
                        <i class="fas fa-plus"></i> Add Service
                    </button>
                </div>
                
                <div class="table-container">
                    <table class="listings-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody id="businessList">
                            <tr id="empty-state">
                                <td colspan="4">
                                    <p>You haven't created any services yet</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Calendar Section -->
            <section class="calendar-section">
                <div class="section-header">
                    <h2>Set Reminders</h2>
                    <div class="view-options">
                        <button class="view-btn active" data-view="day">Day</button>
                        <button class="view-btn" data-view="week">Week</button>
                        <button class="view-btn" data-view="month">Month</button>
                    </div>
                </div>
                <div id="calendar"></div>
            </section>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    
    <!-- Main JS -->
    <script src="/ServiceDiscovery/Assets/js/business.js"></script>
</body>
</html>