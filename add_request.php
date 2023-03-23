<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $user_message = $_POST['user_message'];
    $bot_message = $_POST['bot_message'];

    // Insertion des données dans la table request-chat
    $sql = "INSERT INTO request_chat (user_message, bot_message) VALUES ('$user_message', '$bot_message')";

    if ($conn->query($sql) === TRUE) {
        // Redirection vers la page des requêtes avec un message de succès
        header('Location: requests.php?status=success');
        exit;
    } else {
        // Redirection vers la page des requêtes avec un message d'erreur
        header('Location: requests.php?status=error');
        exit;
    }
}
