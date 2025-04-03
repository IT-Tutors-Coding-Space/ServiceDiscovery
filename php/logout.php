<?php
// logout.php

session_start();

// Destroy all session data
session_unset();
session_destroy();

// Return a success response as JSON
echo json_encode(["success" => true]);
?>
