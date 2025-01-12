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
    // Delete the renewal
    $delete_query = "DELETE FROM renewals WHERE renewal_id = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("i", $renewal_id);
    $stmt_delete->execute();
    
    // Redirect after deletion
    header('Location: index.php?message=Renewal Deleted');
    exit();
} else {
    // If the renewal does not belong to the user, redirect with an error
    header('Location: index.php?error=Renewal not found or unauthorized access');
    exit();
}
?>