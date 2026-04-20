<?php
require_once 'assets/db.php';
session_destroy();
header("Location: index.php");
exit;
?>
