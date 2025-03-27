<?php
session_start();
require 'conn.php';

// Set session timeout (e.g., 30 minutes)
$timeout = 30 * 60; // 30 minutes in seconds
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location:".BASE_PATH." /Home/login.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time

/**
 * Check if the user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['id']);
}

/**
 * Check if user is business owner
 */
function isBusinessOwner() {
    return isLoggedIn() && $_SESSION['role'] === "Business Owner";
}

/**
 * Check if user is a customer
 */
function isCustomer() {
    return isLoggedIn() && $_SESSION['role'] === "Customer";
}

/**
 * Force login to access a page
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location:".BASE_PATH." /Home/login.php");
        exit();
    }
}

/**
 * Logout function
 */
function logout() {
    session_unset();
    session_destroy();
    header("Location:".BASE_PATH." /Home/login.php");
    exit();
}
?>
