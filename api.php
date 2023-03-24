<?php
require_once("config.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


function getProductsByCritere($critere, $value)
{
    $conn = connectDB();
    $sql = "SELECT * FROM products WHERE $critere = '$value'";
    $result = $conn->query($sql);

    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($products, $row);
        }
    }
    $conn->close();

    return $products;
}

// Vérifiez la méthode de requête et les paramètres
$method = $_SERVER['REQUEST_METHOD'];
$critere = $_GET['critere'] ?? '';
$value = $_GET['value'] ?? '';

if ($method == 'GET' && !empty($critere) && !empty($value)) {
    $products = getProductsByCritere($critere, $value);
    echo json_encode($products);
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request."));
}
