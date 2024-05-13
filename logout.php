<?php
include_once('config.php');
$login = false;
session_destroy();

header("Location: login.php");
exit;
?>