<?php
session_start();
include '../config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$reservation_id = $_GET['reservation_id'];
$user_id = $_SESSION['user_id'];

// Fetch the reservation details to check its status
$query = "SELECT status_id FROM Reservations WHERE reservation_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $reservation_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $reservation = $result->fetch_assoc();
    
    // Check if the status is either 1 (new) or 4 (pending)
    if ($reservation['status_id'] == 1 || $reservation['status_id'] == 4) {
        // Cancel the reservation by updating its status
        $update_query = "UPDATE Reservations SET status_id = 3 WHERE reservation_id = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("i", $reservation_id);
        $stmt_update->execute();
        
        // Redirect after cancellation
        header('Location: ../dashboard.php?message=Reservation Cancelled');
        exit();
    } else {
        // If the reservation cannot be canceled, show an error message
        echo "Reservation cannot be canceled. Only pending or expired reservations can be canceled.";
    }
} else {
    // If no reservation found for the given ID or the user, redirect
    header('Location: ../dashboard.php?error=Reservation not found');
    exit();
}
?>