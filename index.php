<?php
session_start();
require_once("config.php");
$conn = connectDB();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>
    <!-- TODO add more graph -->
    <?php require 'templates/header.php'; ?>
    <div class="container">
        <h1>Dashboard SneakMe</h1>
        <div class="dashboard">
            <div class="faux-iframe">
                <div class="graphs">
                    <div class="graph">
                        <div class="bar" style="--height: 50%; --color: #5c6bc0;" data-value="50%">
                            <div class="bar-inner"></div>
                        </div>
                        <div class="bar" style="--height: 80%; --color: #9ccc65;" data-value="80%">
                            <div class="bar-inner"></div>
                        </div>
                        <div class="bar" style="--height: 30%; --color: #ef5350;" data-value="30%">
                            <div class="bar-inner"></div>
                        </div>
                        <div class="bar" style="--height: 60%; --color: #ff9800;" data-value="60%">
                            <div class="bar-inner"></div>
                        </div>
                        <div class="bar" style="--height: 40%; --color: #26a69a;" data-value="40%">
                            <div class="bar-inner"></div>
                        </div>
                        <div class="bar" style="--height: 90%; --color: #7e57c2;" data-value="90%">
                            <div class="bar-inner"></div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>
</body>

</html>
<script>
    var xValues = ["Rose", "Gris", "Bleu", "Rouge", "Vert", "Jaune"];
    var yValues = [55, 49, 41, 24, 15, 3];
    var barColors = [
        "#FFBBEE",
        "#808080",
        "#5c6bc0",
        "#ef5350",
        "#9ccc65",
        "#ff9800"
    ];

    new Chart("myChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        }
    });
</script>