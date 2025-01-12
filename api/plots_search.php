<?php
include '../config.php';

// Start the session
session_start();
// Fetch all plots with related plot type and service type details
$query = "SELECT p.plot_id, p.row_number, p.column_number, p.plot_code, p.availability, 
                 pt.plot_type_name, st.service_type_name,s.service_name, p.geo_position, p.tier,, d.deceased_name
          FROM Plots p
          INNER JOIN PlotTypes pt ON p.plot_type_id = pt.plot_type_id
          INNER JOIN ServiceTypes st ON p.service_type_id = st.service_type_id
          INNER JOIN Services s ON p.service_id = s.service_id
          INNER JOIN Deceased_info d ON p.deceased_id = d.deceased_id
          ";
          
$result = $conn->query($query);

$plots = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plots[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($plots);
?>