<?php
$product_id = (int)explode('/', $request_uri)[3];
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    http_response_code(200);
    echo json_encode($product);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Product not found"]);
}

$conn->close();
