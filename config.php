<?php
// include 'middleware.php';

// Database Configuration
define('DB_HOST', 'localhost');    // Database Host
define('DB_USER', 'root');         // Database Username
define('DB_PASS', '');             // Database Password
define('DB_NAME', 'gis'); // Database Name

// Establishing Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>