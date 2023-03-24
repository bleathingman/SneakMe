<?php
session_start();
require_once("config.php");
$conn = connectDB();

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
    <title>Commandes</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <div class="container">
        <h1>Commandes</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur ID</th>
                    <th>Produit ID</th>
                    <th>Quantité</th>
                    <th>Prix Total</th>
                    <th>Date de Commandes</th>
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
    </div>
    <script src="assets/js/script.js"></script>
</body>

</html>