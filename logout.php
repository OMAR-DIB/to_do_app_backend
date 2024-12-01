<?php
session_unset();
session_destroy();

// Redirect the user to the login page
header("Location: ./login/login.php");

?>