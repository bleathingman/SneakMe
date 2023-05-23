<?php
require_once("../config.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function getCommands()
{
    $conn = connectDB();
    $sql = "SELECT bot_message, description FROM request_chat";
    $result = $conn->query($sql);

    $commands = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($commands, $row); // Ajouter toute la ligne, pas seulement bot_message
        }
    }
    $conn->close();

    return $commands;
}


// Vérifiez la méthode de requête et les paramètres
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $responses = getCommands();
    echo json_encode($responses); // Ce sera un tableau de réponses de bot
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request."));
}
