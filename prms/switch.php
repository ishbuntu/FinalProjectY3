<?php 
session_start();
$_SESSION['role'] = $_SESSION['role'] == 'Tenant' ? 'Property Owner' : 'Tenant';
header('Location: index.php');
?>