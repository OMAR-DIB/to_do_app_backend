<?php
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Redirect the user to the login page
header("Location: ./login/login.php");

?>