<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();

// Fetch all service types
$query = "SELECT * FROM ServiceTypes";
$result = $conn->query($query);

$serviceTypes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $serviceTypes[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($serviceTypes);
?>