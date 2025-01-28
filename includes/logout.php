<?php
// includes/logout.php
session_start();
session_unset();
session_destroy();
header("Location: /whitesoft/index.php");
exit;
?>