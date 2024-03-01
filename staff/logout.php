<?php
//LOGOUT
session_start();
session_destroy();
header('Location: ../staff_login.php');
?>