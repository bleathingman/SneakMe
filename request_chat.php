<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Connexion à la base de données
require_once 'config.php';

// Récupération des demandes de chat
$sql = "SELECT * FROM request_chat";
$result = $conn->query($sql);

// Tableau des réponses possibles
$responses = array(
    'Bonjour' => 'Bonjour ! Comment puis-je vous aider ?',
    'Tailles' => 'Voici la liste des tailles disponibles : ',
    // Ajoutez ici d'autres réponses possibles
);

// Traitement de chaque demande de chat
while ($row = $result->fetch_assoc()) {
    $request = $row['request'];

    // Vérification des demandes spécifiques
    if (strtolower($request) === 'tailles') {
        // Récupération des tailles distinctes de la table 'products'
        $sql_sizes = "SELECT DISTINCT size FROM products";
        $result_sizes = $conn->query($sql_sizes);

        // Construction de la réponse
        $sizes = array();
        while ($size_row = $result_sizes->fetch_assoc()) {
            array_push($sizes, $size_row['size']);
        }
        $response = $responses[$request] . implode(', ', $sizes);
    } else {
        // Réponse par défaut
        $response = $responses[$request];
    }

    // Enregistrement de la réponse dans la base de données
    $sql_response = "UPDATE request_chat SET response = '$response' WHERE id = " . $row['id'];
    $conn->query($sql_response);
}

// Fermeture de la connexion à la base de données
$conn->close();
