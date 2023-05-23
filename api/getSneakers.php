<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../config.php");

$conn = connectDB();

$sql = "SELECT product_name, price, id FROM products LIMIT 100";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sneakers = [];
    while ($row = $result->fetch_assoc()) {
        $sneakers[] = $row;
    }
    echo json_encode($sneakers);
} else {
    echo json_encode([]);
}

$conn->close();
