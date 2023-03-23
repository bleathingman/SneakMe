<?php
$post_data = json_decode(file_get_contents("php://input"), true);
$user_id = $post_data["user_id"];
$product_id = $post_data["product_id"];
$quantity = $post_data["quantity"];

$sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $product_id, $quantity);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "Order created successfully", "order_id" => $conn->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create order"]);
}

$stmt->close();
$conn->close();
