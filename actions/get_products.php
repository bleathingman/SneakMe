<?php
header("Content-Type: application/json");

$request_method = $_SERVER["REQUEST_METHOD"];
$request_uri = $_SERVER["REQUEST_URI"];

require_once("../config.php");
$conn = connectDB();

switch ($request_method) {
    case "GET":
        if (preg_match("/^\/api\/products\/?$/", $request_uri)) {
            include("actions/get_products.php");
        } elseif (preg_match("/^\/api\/products\/\d+\/?$/", $request_uri)) {
            include("actions/get_product.php");
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Not found"]);
        }
        break;
    case "POST":
        if (preg_match("/^\/api\/orders\/?$/", $request_uri)) {
            include("actions/create_order.php");
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Not found"]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
