<?php
// pages/admin_logout.php
session_start();
session_unset();
session_destroy();
header("Location: ../pages/admin_login.php");
exit;
?>