<?php
session_start();



$message = '';
if (isset($_SESSION['error'])) {
    $message = "<div id='pop-message-reg' class='popup' style='background: red; padding: 10px; border-radius: 10px; color: white;'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
} elseif (isset($_SESSION['success'])) {
    $message = "<div id='pop-message-reg' class='popup'   style='background: green; padding: 10px; border-radius: 10px; color: white;'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitButton = document.getElementById('submitButton');
        const errorDiv = document.getElementById('error');
        const popMessage = document.getElementById('pop-message-reg');
        if (popMessage || errorDiv) {
            // Set a timeout to hide the pop message after 5 seconds
            setTimeout(function() {
                popMessage.style.display = 'none';
                errorDiv.style.display = 'none';

            }, 3000)
        }

        function validateEmailInputs() {
            const email = emailInput.value.trim();

            let errors = [];

            // Validate email format
            const isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            if (!isEmailValid) {
                errors.push("Invalid email format.");
            }


            // Display errors or enable the button
            if (errors.length > 0) {
                errorDiv.style.display = 'block'
                errorDiv.innerHTML = errors.join('<br>');
                submitButton.disabled = true;
            } else {
                errorDiv.innerHTML = '';
                errorDiv.style.display = 'none';
                submitButton.disabled = false;
            }
        }

        function validatePassInputs() {

            const password = passwordInput.value.trim();


            // Validate password length
            if (password.length < 6) {
                errors.push("Password must be at least 6 characters long.");
            }



            // Display errors or enable the button
            if (errors.length > 0) {
                errorDiv.style.display = 'block'
                errorDiv.innerHTML = errors.join('<br>');
                submitButton.disabled = true;
            } else {
                errorDiv.innerHTML = '';
                errorDiv.style.display = 'none';
                submitButton.disabled = false;
            }
        }

        function validateConfirmPassInputs() {

            const password = passwordInput.value.trim();
            const confirmPassword = confirmPasswordInput.value.trim();
            let errors = [];



            // Confirm password matches
            if (password !== confirmPassword) {
                errors.push("Passwords do not match.");
            }

            // Display errors or enable the button
            if (errors.length > 0) {
                errorDiv.style.display = 'block'

                errorDiv.innerHTML = errors.join('<br>');
                submitButton.disabled = true;
            } else {
                errorDiv.innerHTML = '';
                errorDiv.style.display = 'none';
                submitButton.disabled = false;
            }
        }

        // Attach validation listeners
        emailInput.addEventListener('input', validateEmailInputs);
        passwordInput.addEventListener('input', validatePassInputs);
        confirmPasswordInput.addEventListener('input', validateConfirmPassInputs);
    });
    </script>
</head>

<body>
    <div class="container-flex">
        <div class="form-container">
            <?php if (isset($message)): ?>
            <?php echo $message; ?>
            <?php endif; ?>
            <div id="error" class="popup error"
                style=' display:none; background: red; padding: 10px; border-radius: 10px; color: white;'></div>
            <form action="api/auth-register.php" method="POST">
                <h2>Register</h2>
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                    required>

                <div class="btnWrap">
                    <button class="btn-auth" type="submit" id="submitButton" disabled>Register</button>
                </div>
            </form>
            <p>Already have an account? <a href="login.php" style="color:red;">Login here</a>.</p>
        </div>
    </div>
</body>

</html>