<?php

$host = "localhost";
$dbname = "service_connect";
$username = "root";
$password = "";

define("BASE_PATH", "/ServiceDiscovery/pages/");

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
