<?php
include '../config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session (only once)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleReservation($_POST);
    // var_dump($_POST);

}

function handleReservation($request) {
    global $conn;
    // var_dump($request);

    // Start transaction
    // $conn->begin_transaction();

    try {
        // 1. Handle File Upload
        $paymentProofPath = uploadPaymentProof($_FILES['payment_proof']);
        $userId = $_SESSION['user_id'];
        // var_dump($_FILES['payment_proof']);

        // 2. Get or Create Deceased_Info
        $deceasedId = getOrCreateDeceasedInfo(
            $conn, 
            $request['deceased_name'], 
            $request['date_of_birth'], 
            $request['date_of_death']
        );
        // 3. Check if the deceased_id is already assigned to a plot
        if (checkDeceasedInPlots($conn, $deceasedId)&& isset($request['plot_code'])) {
            // If the deceased_id is already associated with a plot, return an error
             $_SESSION['error_message'] ="The deceased is already associated with a plot.";
            header("Location: ../reservation_form.php");
             
            throw new Exception("The deceased is already associated with a plot.");
        }
        

        // 3. Insert into Reservations
        $reservationId = insertReservation(
            $conn,
            $userId,
            isset($request['plot_code']) ? $request['plot_code'] : null, // Send plot_code if it exists
            $request['holder_name'],
            $request['holder_address'],
            $request['holder_phone'],
            $request['holder_email'],
            (int) $request['payment_method'],
            $paymentProofPath,
            (int) $request['status_id'], // Cast to integer
            (int) $deceasedId // Cast to integer
        );
        
        echo "Inserting reservation...";
        echo "Reservation inserted: " . $reservationId;
        
       

        // 4. Fetch Service Details
        $serviceId = getServiceId($conn, $request['services']);

        // 5. Insert into Reservation_Details
        $reservationDetailsId = insertReservationDetails(
            $conn,
            (int)$reservationId,
            (int) $serviceId,
            $request['amount'],
            $request['start_date'],
            $request['fee_code']
        );
        // Check if the reservation was successful
        if ($reservationId && $reservationDetailsId) {
            // Redirect to index.php
            header("Location: ../dashboard.php");
            exit();
        } else {
            // If there's an error, set an error message and stay on the form
            $_SESSION['error_message'] = "Reservation could not be processed. Please try again." ;
            header("Location: ../reservation_form.php");
            exit();
        }
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
    // var_dump($file);  // Debug: Check the contents of $_FILES['payment_proof']
    // var_dump($_FILES['payment_proof']);
    // Check if the file is actually uploaded
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($file['name']);
        
        // Move the file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile;  // Return the file path
        } else {
            throw new Exception("Failed to upload payment proof");
        }
    }
    
    // Handle cases where file upload fails
    throw new Exception("No file uploaded or upload error: " . $file['error']);
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
        $stmt->bind_param("sss", $name, $dob, $dod);
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
    // var_dump($userId, $plotCode, $holderName, $holderAddress, $holderPhone, $holderEmail, $paymentMethod, $paymentProof, $statusId, $deceasedId);
    
    // Bind parameters, including plotCode (which can be null)
    $stmt->bind_param(
        "isssssisii",
        $userId, $plotCode, $holderName, $holderAddress, $holderPhone, $holderEmail, 
        $paymentMethod, $paymentProof, $statusId, $deceasedId
    );
    $stmt->execute();

    // Check for errors in the query execution
    if ($stmt->errno) {
        // Output the error message
        $error_message = "Error executing query: " . $stmt->error;
        var_dump($error_message);  // Logs to PHP's error log
        throw new Exception($error_message);  // Throw an exception to be caught by your try-catch block
    }
    
    // Return the insert ID
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

function insertReservationDetails($conn, $reservationId, $serviceId, $amount, $startDate,$feeCode) {
    // Prepare the SQL query
    $stmt = $conn->prepare("
        INSERT INTO Reservation_Details 
        (reservation_id, service_id, amount, start_date,fee_code) 
        VALUES (?, ?, ?, ?, ?)
    ");

    // Check if the prepare failed
    if (!$stmt) {
        // If the statement preparation failed, output the error
        var_dump("Error preparing query: " . $conn->error);
        return false; // You may want to throw an exception or handle this as needed
    }

    // Debugging - Check the values before binding
    var_dump($reservationId, $serviceId, $amount, $startDate,$feeCode);

    // Bind the parameters
    $stmt->bind_param("iidss", $reservationId, $serviceId, $amount, $startDate,$feeCode);

    // Execute the query
    if (!$stmt->execute()) {
        // Output error message if execution fails
        $error_message = "Error executing query: " . $stmt->error;
        var_dump($error_message);  
        throw new Exception($error_message);  
    }

    // Return the insert ID
    return $conn->insert_id;
}
// Function to check if the deceased_id is already assigned to a plot
function checkDeceasedInPlots($conn, $deceasedId) {
    $stmt = $conn->prepare("SELECT deceased_id FROM plots WHERE deceased_id = ?");
    $stmt->bind_param("i", $deceasedId);  // Use integer for deceased_id
    $stmt->execute();
    $result = $stmt->get_result();
    var_dump($result); 
    // If a result is found, the deceased_id is already assigned to a plot
    return $result->num_rows > 0;
}

$conn->close();
?>