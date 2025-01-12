<?php
include '../config.php';

// Start the session
session_start();

// Fetch all fees along with the service_name and service_type_name
$query = "
    SELECT f.*, s.service_name, st.service_type_name
    FROM fees f
    INNER JOIN Services s ON f.service_id = s.service_id
    INNER JOIN ServiceTypes st ON s.service_type_id = st.service_type_id
";
$result = $conn->query($query);

$fees = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fees[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($fees);
?>