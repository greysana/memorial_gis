<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();
// Fetch all services with their service type
$query = "SELECT s.service_id, s.service_name, st.service_type_name 
          FROM Services s
          INNER JOIN ServiceTypes st ON s.service_type_id = st.service_type_id";

$result = $conn->query($query);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($services);
?>