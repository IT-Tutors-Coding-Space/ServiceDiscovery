<?php
session_start();
session_destroy();
header("Location: /Service/pages/Home/login.html");
exit();
?>