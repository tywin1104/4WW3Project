<?php
session_start();
unset($_SESSION['loggedIn']);
header("Location: signin.php");
die();
?>
