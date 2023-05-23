<?php
require_once("config.php");

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

function getAllCommands()
{
    $conn = connectDB();
    $sql = "SELECT * FROM request_chat";
    $result = $conn->query($sql);

    $commands = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($commands, $row);
        }
    }
    $conn->close();

    return $commands;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $commands = getAllCommands();
    echo json_encode($commands);
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request."));
}
