<?php
 $host = "localhost";
 $user = "root"; // Default user in XAMPP
 $pass = ""; // No password by default
 $dbname = "service discovery"; //  database name

// Create connection
 $conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
