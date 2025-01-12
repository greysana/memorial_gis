<?php
session_start();
$message = '';
if (isset($_SESSION['error'])) {
    $message = "<div  id='pop-message-log' class='popup' style='background: red; padding: 10px; border-radius: 10px; color: white;'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
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
            let errors = [];



            // Validate password is not empty
            if (password.length === 0) {
                errors.push("Password cannot be empty.");
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
                style='display:none; background: red; padding: 10px; border-radius: 10px; color: white;'></div>
            <form action="api/auth-login.php" method="POST">
                <h2>Login</h2>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="btnWrap">

                    <button class="btn-auth" type=" submit" id="submitButton" disabled>Login</button>
                </div>
            </form>
            <p>Don't have an account? <a href="register.php" style="color:red;">Register here</a>.</p>
        </div>
    </div>
</body>

</html>