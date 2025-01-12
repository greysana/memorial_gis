<?php
include 'middleware.php';
include '../config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $payment_method = $_POST['payment_method'];
    $amount = $_POST['amount']; 
    $fee_code = $_POST['fee_code'] ?? null; 
    $user_id = $_SESSION['user_id'];

    // Validate reservation_id
    $reservation_check_sql = "SELECT COUNT(*) AS count FROM reservations WHERE reservation_id = ?";
    $reservation_check_stmt = $conn->prepare($reservation_check_sql);
    $reservation_check_stmt->bind_param('i', $reservation_id);
    $reservation_check_stmt->execute();
    $reservation_result = $reservation_check_stmt->get_result();
    $row = $reservation_result->fetch_assoc();

    if ($row['count'] == 0) {
        echo "Invalid reservation ID.";
        exit;
    }
    // Handle file upload
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        $file_name = basename($_FILES['payment_proof']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target_file)) {
            $payment_proof = $file_name;
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        echo "File upload error.";
        exit;
    }

    // Default status for a new renewal (e.g., Pending)
    $status_id = 1;

    // Insert into renewals table
    $sql = "
        INSERT INTO renewals (
            reservation_id, user_id, status_id, amount, fee_code, payment_method_id, payment_proof
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiidsis', $reservation_id, $user_id, $status_id, $amount, $fee_code, $payment_method, $payment_proof);

    if ($stmt->execute()) {
        echo "Renewal submitted successfully.";
        header("Location: ../dashboard.php");
        
    } else {
        echo "Error submitting renewal.";
        $error_message = "Error executing query: " . $stmt->error;
        $_SESSION['error_message'] = "Renewal could not be processed. Please try again." ;
        header("Location: ../renewal_form.php");
        throw new Exception($error_message); 
    }

    $stmt->close();
    $conn->close();
}
?>