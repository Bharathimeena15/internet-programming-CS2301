<?php
require_once 'includes/functions.php';
session_unset();
session_destroy();
session_start();
$_SESSION['flash_message'] = "You have been logged out.";
$_SESSION['flash_type'] = "info";
redirect("login.php");
?>
