<?php
// Database configuration
$host = '127.0.0.1';      // Database host (localhost or IP)
$user = 'root';           // Database username
$password = '';           // Database password
$dbname = 'todolistapp';     // Database name

// Establish connection
$connection = mysqli_connect($host, $user, $password, $dbname);

// Check the connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Optional: Set the character set to UTF-8 for proper encoding
mysqli_set_charset($connection, "utf8mb4");

// Connection successful message (for debugging, remove in production)
// echo "Database connection successful!";
?>
