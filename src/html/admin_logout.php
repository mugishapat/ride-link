<?php
session_start();

// Clear all session data
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: admin_login.php");
exit();
?>
