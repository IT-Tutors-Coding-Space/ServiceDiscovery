<?php
session_start();
require 'conn.php';
$_SESSION = [];
session_destroy();
setcookie(session_name(),'',time() - 3600, '/');
header("Location: " . BASE_PATH . "Home/login.php");
exit();
?>