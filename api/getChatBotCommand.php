<?php
require_once("../config.php");

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

function getChatBotCommands($command)
{
    $conn = connectDB();
    $sql = "SELECT * FROM request_chat WHERE user_message = '$command'";
    $result = $conn->query($sql);

    $commands = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($commands, $row['bot_message']); // On pousse uniquement la réponse du bot dans le tableau
        }
    }
    $conn->close();

    return $commands;
}


// Vérifiez la méthode de requête et les paramètres
$method = $_SERVER['REQUEST_METHOD'];
$command = $_GET['command'] ?? '';

if ($method == 'GET' && !empty($command)) {
    $responses = getChatBotCommands($command);
    echo json_encode($responses); // Ce sera un tableau de réponses de bot
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request."));
}
