<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();

// Registration Function
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if the email already exists
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If the email already exists, store error message in session
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Error: This email address is already registered.";
        header("Location: ../register.php"); // Redirect back to registration page
        exit();
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into the database
        $sql_insert = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! Please log in.";
            header("Location: ../login.php"); // Redirect to login page
            exit();
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
            header("Location: ../register.php"); // Redirect back to registration page
            exit();
        }
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>