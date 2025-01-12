<?php
include '../config.php';
// Start the session
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start the session
session_start();
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
handleReservation();
function handleReservation($request) {
    global $conn;

    // Start transaction
    $conn->begin_transaction();

    try {
        // 1. Handle File Upload
        $paymentProofPath = uploadPaymentProof($request['payment_proof']);
        $userId=$_SESSION['user_id'];
        // 2. Get or Create Deceased_Info
        $deceasedId = getOrCreateDeceasedInfo(
            $conn, 
            $request['deceased_name'], 
            $request['date_of_birth'], 
            $request['date_of_death']
        );

        // 3. Insert into Reservations
        $reservationId = insertReservation(
            $conn,
            $userId,
            isset($request['plot_code']) ? $request['plot_code'] : null, // Send plot_code if it exists
            $request['holder_name'],
            $request['holder_address'],
            $request['holder_phone'],
            $request['holder_email'],
            $request['payment_method'],
            $paymentProofPath,
            $request['status_id'],
            $deceasedId
        );
           // Check if the reservation was successful
        if ($reservationId) {
            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            // If there's an error, set an error message and stay on the form
            $_SESSION['error_message'] = "Reservation could not be processed. Please try again.";
            header("Location: reservation_form.php");
            exit();
        }
        // 4. Fetch Service Details
        $serviceId = getServiceId($conn, $request['services']);

        // 5. Insert into Reservation_Details
        insertReservationDetails(
            $conn,
            $reservationId,
            $serviceId,
            $request['amount'],
            $request['start_date']
        );

        // Commit the transaction
        $conn->commit();

        return ['success' => true, 'message' => 'Reservation created successfully'];
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function uploadPaymentProof($file) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    throw new Exception("Failed to upload payment proof");
}

function getOrCreateDeceasedInfo($conn, $name, $dob, $dod) {
    $stmt = $conn->prepare("SELECT deceased_id FROM Deceased_Info WHERE deceased_name = ? AND date_of_birth = ?");
    $stmt->bind_param("ss", $name, $dob);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['deceased_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO Deceased_Info (deceased_name, date_of_birth, date_of_death) VALUES (?, ?, ?)");
        $stmt->bind_param("ssss", $name, $dob, $dod);
        $stmt->execute();
        return $conn->insert_id;
    }
}

function insertReservation($conn, $userId, $plotCode, $holderName, $holderAddress, $holderPhone, $holderEmail, $paymentMethod, $paymentProof, $statusId, $deceasedId) {
    $stmt = $conn->prepare("
        INSERT INTO Reservations 
        (user_id, plot_code, holder_name, holder_address, holder_phone, holder_email, payment_method_id, payment_proof, status_id, deceased_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    // Bind parameters, including plotCode (which can be null)
    $stmt->bind_param(
        "issssssisi",
        $userId, $plotCode, $holderName, $holderAddress, $holderPhone, $holderEmail, 
        $paymentMethod, $paymentProof, $statusId, $deceasedId
    );
    $stmt->execute();
    return $conn->insert_id;
}


function getServiceId($conn, $services) {
    $stmt = $conn->prepare("SELECT service_id FROM Services WHERE service_name = ?");
    $stmt->bind_param("s", $services);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['service_id'];
    }
    throw new Exception("Service not found");
}

function insertReservationDetails($conn, $reservationId, $serviceId, $amount, $startDate) {
    $stmt = $conn->prepare("
        INSERT INTO Reservation_Details 
        (reservation_id, service_id, amount, start_date) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisss", $reservationId, $serviceId, $amount, $startDate);
    $stmt->execute();
}
// }
$conn->close();

?>