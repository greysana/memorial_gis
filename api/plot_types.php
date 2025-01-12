<?php
include '../config.php';

// Start the session
session_start();
// Fetch all plot types

$query = "
    SELECT p.*, s.service_name
    FROM PlotTypes p
    INNER JOIN Services s ON p.service_id = s.service_id
    
";
$result = $conn->query($query);

$plotTypes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plotTypes[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($plotTypes);
?>