<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Optionnel : Supprimer l'image du produit
    $result = $conn->query("SELECT image FROM products WHERE id = $id");
    $row = $result->fetch_assoc();
    $file_path = "uploads/" . $row["image"];
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../index.php");
} else {
    echo "Erreur: méthode de requête invalide.";
}
