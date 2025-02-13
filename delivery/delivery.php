<?php
ob_start();
include("connect.php");
include '../connection.php';

// Check if the user is logged in
if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
    exit;
}

// Session variables
$name = $_SESSION['name'];
$city = $_SESSION['city'];
$id = $_SESSION['Did']; // Delivery person ID

// Fetch unassigned orders based on city
$sql = "
    SELECT 
        fd.Fid AS Fid,
        fd.location AS cure,
        fd.name,
        fd.phoneno,
        fd.date,
        fd.delivery_by,
        fd.address AS From_address,
        ad.name AS delivery_person_name,
        ad.address AS To_address
    FROM 
        food_donations fd
    LEFT JOIN 
        admin ad ON fd.assigned_to = ad.Aid
    WHERE 
        fd.assigned_to IS NOT NULL 
        AND fd.delivery_by IS NULL 
        AND fd.location = '$city';
";

$result = mysqli_query($connection, $sql);

// Check for query execution errors
if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}

// Fetch the data as an associative array
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Handle "Take Order" form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['food']) && isset($_POST['delivery_person_id'])) {
    $order_id = $_POST['order_id'];
    $delivery_person_id = $_POST['delivery_person_id'];

    // Check if the order is already assigned
    $check_sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND delivery_by IS NOT NULL";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Sorry, this order has already been assigned to someone else.";
    } else {
        // Assign the order to the delivery person
        $update_sql = "UPDATE food_donations SET delivery_by = $delivery_person_id WHERE Fid = $order_id";
        $update_result = mysqli_query($connection, $update_sql);

        if (!$update_result) {
            die("Error assigning order: " . mysqli_error($connection));
        }

        // Reload the page to prevent duplicate submissions
        header('Location: ' . $_SERVER['REQUEST_URI']);
        ob_end_flush();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
    <style>
        .itm {
            background-color: white;
            display: grid;
        }
        .itm img {
            width: 400px;
            height: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        p {
            text-align: center;
            font-size: 30px;
            color: black;
            margin-top: 50px;
        }
        @media (max-width: 767px) {
            .itm img {
                width: 350px;
                height: 350px;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <nav class="nav-bar">
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="openmap.php">Map</a></li>
            <li><a href="deliverymyord.php">My Orders</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<br>
<h2><center>Welcome <?php echo htmlspecialchars($name); ?></center></h2>
<div class="itm">
    <img src="../img/delivery.gif" alt="Delivery Animation" width="400" height="400">
</div>


