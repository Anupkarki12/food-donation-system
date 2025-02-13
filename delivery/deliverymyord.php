<?php
ob_start();
// session_start(); // Ensure session is started

// Include database connections
include '../connection.php';
include("connect.php");

// Redirect if the user is not logged in
if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
    exit;
}

$name = $_SESSION['name'];
$id = $_SESSION['Did']; // Delivery person ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="delivery.css">
    <link rel="stylesheet" href="../home.css">
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="delivery.php">Home</a></li>
            <li><a href="openmap.php">Map</a></li>
            <li><a href="deliverymyord.php" class="active">My Orders</a></li>
        </ul>
    </nav>
</header>
<br>
<script>
    hamburger = document.querySelector(".hamburger");
    hamburger.onclick = function () {
        navBar = document.querySelector(".nav-bar");
        navBar.classList.toggle("active");
    }
</script>
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
        font-size: 28px;
        color: black;
    }
    @media (max-width: 767px) {
        .itm img {
            width: 350px;
            height: 350px;
        }
    }
</style>

<div class="itm">
    <img src="../img/delivery.gif" alt="Delivery Animation" width="400" height="400">
</div>

<div class="get">
    <?php
    // Query to fetch unassigned orders and orders assigned to the logged-in delivery person
    $sql = "SELECT fd.Fid AS Fid, fd.name, fd.phoneno, fd.date,fd.expiry, fd.delivery_by, 
                   fd.address AS From_address, ad.address AS To_address
            FROM food_donations fd
            LEFT JOIN admin ad ON fd.assigned_to = ad.Aid
            WHERE fd.delivery_by IS NULL OR fd.delivery_by = '$id'";

    $result = mysqli_query($connection, $sql);

    // Check for query errors
    if (!$result) {
        die("Error executing query: " . mysqli_error($connection));
    }

    // Fetch the data
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Display a message if no orders are available
    if (empty($data)) {
        echo "<p>No orders available at the moment.</p>";
    }
    ?>
</div>

<!-- Display the orders in an HTML table -->
<?php if (!empty($data)) { ?>
    <div class="table-container">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone No</th>
                    <th>Date/Time</th>
                    <th>Expiry Date</th>
                    <th>Pickup Address</th>
                    <th>Delivery Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['phoneno']); ?></td>
                        <td><?= htmlspecialchars($row['date']); ?></td>
                        <td><?= htmlspecialchars($row['expiry']); ?></td>
                        <td><?= htmlspecialchars($row['From_address']); ?></td>
                        <td><?= htmlspecialchars($row['To_address'] ?? 'Not Assigned'); ?></td>
                        <td>
                            <?php if ($row['delivery_by'] == null) { ?>
                                <!-- Assign Order Button -->
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?= $row['Fid']; ?>">
                                    <button type="submit" name="assign_order">Take Order</button>
                                </form>
                            <?php } else { ?>
                                Ordered
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<?php
// Handle the "Take Order" button
if (isset($_POST['assign_order'])) {
    $order_id = $_POST['order_id'];

    // Assign the order to the logged-in delivery person
    $assign_sql = "UPDATE food_donations SET delivery_by = '$id' WHERE Fid = '$order_id' AND delivery_by IS NULL";

    $assign_result = mysqli_query($connection, $assign_sql);

    if (!$assign_result) {
        die("Error assigning order: " . mysqli_error($connection));
    } else {
        // Reload the page to reflect the updated order status
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>


</body>
</html>
