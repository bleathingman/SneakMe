<?php
require_once("config.php");

$product_name = $_GET["product_name"];

$sql = "SELECT * FROM products WHERE product_name = :product_name";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":product_name", $product_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($result);
