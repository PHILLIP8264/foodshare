<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the homepage (or login page if you prefer)
header('Location: index.php');
exit;
?>
