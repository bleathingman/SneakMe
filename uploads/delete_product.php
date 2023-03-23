<?php
function deleteProduct($id)
{
    require_once 'config.php';

    // Préparation de la requête SQL
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Exécution de la requête SQL
    if ($stmt->execute()) {
        echo "Le produit a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du produit : " . $stmt->error;
    }

    // Fermeture de la connexion à la base de données
    $stmt->close();
    $conn->close();
}
