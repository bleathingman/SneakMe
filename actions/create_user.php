<?php
$post_data = json_decode(file_get_contents("php://input"), true);
$username = $post_data["username"];
$password = password_hash($post_data["password"], PASSWORD_DEFAULT);
$email = $post_data["email"];

$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $email);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "User created successfully", "user_id" => $conn->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create user"]);
}

$stmt->close();
$conn->close();
