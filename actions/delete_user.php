<?php
require_once("config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_user"])) {
    $id = $_GET["delete_user"];

    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM users WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../users.php");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$conn->close();
?>