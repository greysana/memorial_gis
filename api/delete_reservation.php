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

// Fetch the reservation details to ensure it belongs to the logged-in user
$query = "SELECT * FROM Reservations WHERE reservation_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $reservation_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Delete the reservation
    $delete_query = "DELETE FROM Reservations WHERE reservation_id = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("i", $reservation_id);
    $stmt_delete->execute();
    
    // Redirect after deletion
    header('Location: index.php?message=Reservation Deleted');
    exit();
} else {
    // If the reservation does not belong to the user, redirect with an error
    header('Location: index.php?error=Reservation not found or unauthorized access');
    exit();
}
?>