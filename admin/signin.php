<?php
session_start();
include '../connection.php'; // Ensure this file initializes $connection properly
$msg = 0;


if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize inputs to prevent SQL injection
    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    // Check if the user exists
    $sql = "SELECT * FROM admin WHERE email = '$sanitized_emailid'";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($sanitized_password, $row['password'])) {
            // Set session variables
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];
            $_SESSION['location'] = $row['location'];
            $_SESSION['Aid'] = $row['Aid'];

            // Redirect to admin page
            header("Location: admin.php");
            exit();
        } else {
            $msg = 1; // Incorrect password
        }
    } else {
        $msg = 2; // Account does not exist
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formstyle.css"> <!-- Ensure this file exists in the same directory -->
    <script src="signin.js" defer></script> <!-- Ensure this file exists -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form action="signin.php" id="form" method="post">
            <span class="title">Login</span>
            <br><br>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
                <div class="error"></div>
            </div>
            <label class="textlabel" for="password">Password</label>
            <div class="password">
                <input type="password" name="password" id="password" required>
                <i class="fas fa-eye-slash showHidePw" id="showpassword"></i>
                <?php
                if ($msg == 1) {
                    echo '<p class="error">Incorrect password. Please try again.</p>';
                } elseif ($msg == 2) {
                    echo '<p class="error">Account does not exist. Please register.</p>';
                }
                ?>
            </div>
            <button type="submit" name="sign">Login</button>
            <div class="login-signup">
                <span class="text">Don't have an account?
                    <a href="signup.php" class="text login-link">Register</a>
                </span>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const showPasswordToggle = document.getElementById("showpassword");
            const passwordInput = document.getElementById("password");

            if (showPasswordToggle && passwordInput) {
                showPasswordToggle.addEventListener("click", () => {
                    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                    passwordInput.setAttribute("type", type);
                    showPasswordToggle.classList.toggle("fa-eye");
                    showPasswordToggle.classList.toggle("fa-eye-slash");
                });
            }
        });
    </script>
</body>
</html>

