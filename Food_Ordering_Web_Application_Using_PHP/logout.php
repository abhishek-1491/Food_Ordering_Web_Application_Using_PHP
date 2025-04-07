<?php
session_start(); // Start the session

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the homepage
header("Location: login.html"); // Change 'index.php' to your homepage URL
exit();
?>