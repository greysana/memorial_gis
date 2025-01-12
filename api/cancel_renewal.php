<?php
session_start();
include '../config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$renewal_id = $_GET['renewal_id'];
$user_id = $_SESSION['user_id'];

// Fetch the renewal details
$query = "SELECT * FROM renewals WHERE renewal_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $renewal_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Cancel the renewal by deleting it from the database
    $update_query = "UPDATE renewals SET status_id = 3 WHERE renewal_id = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("i", $renewal_id);
        $stmt_update->execute();
    
    // Redirect after deletion
    header('Location: ../dashboard.php?message=Renewal Cancelled');
    exit();
} else {
    // If the renewal does not belong to the user, redirect with an error
    header('Location: ../dashboard.php?error=Renewal not found or unauthorized access');
    exit();
}
?>