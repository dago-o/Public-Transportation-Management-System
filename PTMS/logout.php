<?php
// Start the session
session_start();

// Destroy all session data
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session

// Alert message
echo "<script>alert('You have logged out successfully!');</script>";

// Redirect to login page
echo "<script>window.location.href = 'login.php';</script>";
exit();
?>
