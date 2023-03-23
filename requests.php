<?php
session_start();
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM request_chat";
$result = $conn->query($sql);

$requests = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requêtes ChatBot</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require 'templates/header.php'; ?> <div class="container-fluid py-5">
        <div class="row">
            <main class="col-lg-12">
                <h1>Requêtes ChatBot</h1>

                <!-- Formulaire pour ajouter une nouvelle requête -->
                <form action="add_request.php" method="post">
                    <label for="user_message">Message de l'utilisateur :</label>
                    <input type="text" id="user_message" name="user_message" required>
                    <label for="bot_message">Message du chatbot :</label>
                    <input type="text" id="bot_message" name="bot_message" required>
                    <input type="submit" value="Ajouter la requête">
                </form>

                <!--Tableau pour afficher les requests existante pour le chat bot-->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Message de l'utilisateur</th>
                            <th>Message du chatbot</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $request) { ?>
                            <tr>
                                <td><?php echo $request['id']; ?></td>
                                <td><?php echo $request['user_message']; ?></td>
                                <td><?php echo $request['bot_message']; ?></td>
                                <td><?php echo $request['created_at']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>