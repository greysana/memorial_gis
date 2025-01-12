<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();

try {
    // Query to retrieve plots with foreign key values
    $query = "
        SELECT 
            p.plot_id,
            p.row_number,
            p.column_number,
            p.plot_code,
            p.availability,
            p.tier,
            p.geo_position,
            p.service_id,
            pt.plot_type_name,
            st.service_type_name,
            d.deceased_name,
            s.service_name
        FROM 
            Plots p
        LEFT JOIN 
            PlotTypes pt ON p.plot_type_id = pt.plot_type_id
        LEFT JOIN 
            ServiceTypes st ON p.service_type_id = st.service_type_id
        LEFT JOIN 
            Deceased_Info d ON p.deceased_id = d.deceased_id
        LEFT JOIN 
            Services s ON p.service_id = s.service_id
        
    ";

    // Execute the query
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $plots = [];
        while ($row = $result->fetch_assoc()) {
            $plots[] = $row;
        }

        // Return results as JSON
        header('Content-Type: application/json');
        echo json_encode($plots, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["message" => "No plots found."]);
    }
} catch (Exception $e) {
    // Handle errors
    echo json_encode(["error" => $e->getMessage()]);
}

$conn->close();
?>