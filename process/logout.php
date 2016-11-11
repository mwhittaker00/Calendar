<?php
session_start();
session_unset();
setcookie('user', null, -1, '/');
$success = true;
header('Location:/page/home/');
?>
