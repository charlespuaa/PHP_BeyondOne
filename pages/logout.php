<?php
session_start(); 


$_SESSION = array();

// Destroy the session
session_destroy();


header('Location: store.php');
exit();
?>