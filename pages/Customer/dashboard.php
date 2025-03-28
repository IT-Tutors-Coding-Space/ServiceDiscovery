<?php
require_once "../../php/session_handler.php";

if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}
?>

<header>
    <h2>Welcome to Your Dashboard</h2>
</header>

<section>
    <p>This is your dashboard where you can manage your profile and search for services.</p>
</section>
