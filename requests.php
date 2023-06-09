<?php
session_start();
require_once("config.php");
$conn = connectDB();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $sql = "DELETE FROM request_chat WHERE id = '$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: $_SERVER[PHP_SELF]");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}


$sql = "SELECT * FROM request_chat";
$result = $conn->query($sql);

$requests = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Requêtes ChatBot</title>
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <div class="container" id="scroll">
        <h1>Requêtes ChatBot</h1>

        <!-- Formulaire pour ajouter une nouvelle requête -->
        <form class="form-request" action="create_request.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user_message">Message de l'utilisateur :</label>
                <input type="text" id="user_message" name="user_message" required>
                <label for="bot_message">Message du chatbot :</label>
                <input type="text" id="bot_message" name="bot_message" required>
                <label for="description">Description de la commandes :</label>
                <input type="text" id="description" name="description" required>
            </div>
            <input class="btn btn-add" type="submit" value="Ajouter la requête">
        </form>
        <br>
        <!--Tableau pour afficher les requests existantes pour le chatbot-->
        <div class="scrollable">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Message de l'utilisateur</th>
                        <th>Message du chatbot</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($requests as $request) {
                        echo "<tr>";
                        echo "<td>" . $request["id"] . "</td>";
                        echo "<td>" . $request["user_message"] . "</td>";
                        echo "<td>" . $request["bot_message"] . "</td>";
                        echo "<td>" . $request["description"] . "</td>";
                        echo "<td>";
                        echo "<a class='btn btn-edit' href='actions/edit_request.php?id=" . $request["id"] . "' onclick='openEditModal(event)'>Modifier</a>";
                        echo "<a class='btn btn-delete' href='?delete_id=" . $request["id"] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette requête ?\")'>Supprimer</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>