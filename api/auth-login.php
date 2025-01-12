<?php
// Include the database configuration
include '../config.php';

// Start the session
session_start();


// Login Function
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['token'] = bin2hex(random_bytes(32)); 
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: ../login.php?error=Login Error");
        }
    } else {
        $_SESSION['error'] = "User not found.";
    }
    $stmt->close();
}


$conn->close();
?>