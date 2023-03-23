<?php
session_start();
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: /dashboard/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <h1>Welcome to the Sneakers E-commerce Dashboard</h1>
    <script src="assets/js/script.js"></script>
</body>

</html>