<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'config.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

//init tableau
$products = array();

// verifis si il y a des lignes dans le tableau
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// retourne un json de la liste des produits
echo json_encode($products);
