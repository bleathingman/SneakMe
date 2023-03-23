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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <div class="container-fluid py-5">
        <div class="row">
            <main class="col-lg-12">
                <h1>Dashboard SneakMe</h1>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</body>

</html>