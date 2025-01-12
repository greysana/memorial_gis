<?php
// Include PHPMailer classes
include 'phpmailer/PHPMailer.php';
include 'phpmailer/SMTP.php';
include 'phpmailer/Exception.php';

// Use the PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Set mailer to use SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Use Mailtrap's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = '6e5506f1b4a44e'; // Your Gmail address
        $mail->Password = 'c9ce99fc341b8d'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        echo 'Message here successfully!';

        // Set email sender and recipient
        $mail->setFrom('gandenoflifememorialpark@gmail.com', 'Your Name'); // Your Gmail address
        $mail->addAddress('gandenoflifememorialpark@gmail.com'); // Recipient's email address
        echo 'Message here successfully!';

        // Set email subject and body
        $mail->Subject = $subject;
        echo '3';
        
        $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        echo '4';

        // Send the email
        if ($mail->send()) {
            echo 'Message sent successfully!';
            header("Location: index.php?success_email=true");
        exit;
        } else {
            echo 'Message could not be sent. Mailer Errors: ' . $mail->ErrorInfo;
            header("Location: index.php?email_error=Failed to send email");
        exit;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>