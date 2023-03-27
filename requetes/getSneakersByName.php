<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../config.php");

$product_name = $_GET["product_name"];

$sql = "SELECT * FROM products WHERE product_name = :product_name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":product_name", $product_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($result);
