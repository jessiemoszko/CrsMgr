<?php
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

header("Location: login.php");
exit;
?>
