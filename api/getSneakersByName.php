<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../config.php");

$conn = connectDB();

$product_name = $_GET['product_name'];

$stmt = $conn->prepare("SELECT * FROM products WHERE product_name = ?");
$stmt->bind_param("s", $product_name);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Récupérer les résultats
    $sneaker = $result->fetch_assoc();

    // Renvoyer les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($sneaker);
} else {
    // Renvoyer un message d'erreur au format JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Aucune sneaker trouvée avec le nom "' . $product_name . '".']);
}

$stmt->close();
$conn->close();
