<?php
session_start();
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <div class="container-fluid py-5">
        <div class="row">
            <main class="col-lg-12">
                <h1>Orders</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["user_id"]; ?></td>
                                <td><?php echo $row["product_id"]; ?></td>
                                <td><?php echo $row["quantity"]; ?></td>
                                <td><?php echo $row["total_price"]; ?></td>
                                <td><?php echo $row["order_date"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</body>

</html>