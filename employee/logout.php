<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect the user to the login page with a success message
header("Location: ../index.php?logout=success");
exit();
?>
