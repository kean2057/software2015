<?php
session_start();

$_SESSION['LoggedIn']['u'] = '';
$_SESSION['LoggedIn']['p'] = '';
$_SESSION['LoggedIn']['f'] = '';

header('Location:loginPage.php');
?>