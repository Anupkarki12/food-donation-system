<?php
session_start();
include '../connection.php';

if (isset($_POST['sign'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['district'];
    $address = $_POST['address'];
    $pass = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    if ($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {
        $stmt = $connection->prepare("INSERT INTO admin (name, email, password, location, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $pass, $location, $address);
        if ($stmt->execute()) {
            header("Location: signin.php");
            exit();
        } else {
            error_log("Database Insert Error: " . $connection->error);
            echo '<script>alert("An error occurred. Please try again.");</script>';
        }
    }
}
?>
