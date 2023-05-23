<?php
require_once("config.php");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["size"])) {
    $size = $_POST["size"];

    $sql = "SELECT * FROM products WHERE size = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $size);
    $stmt->execute();
    $result = $stmt->get_result();

    $sneakers = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($sneakers, $row);
        }
    }

    echo json_encode($sneakers);
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request."));
}
