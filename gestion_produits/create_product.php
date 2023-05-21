<?php
require_once("../config.php");
$conn = connectDB();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Check if the database connection is successful
    if ($conn === null) {
        throw new Exception("Erreur de connexion à la base de données.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_name = $_POST["product_name"];
        $brand = $_POST["brand"];
        $color = $_POST["color"];
        $size = $_POST["size"];
        $price = $_POST["price"];
        $image = $_FILES["image"]["name"];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $sql = "INSERT INTO products (product_name, brand, color, size, price, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssds", $product_name, $brand, $color, $size, $price, $image);
        $stmt->execute();

        header("Location: ../index.php");
    } else {
        throw new Exception("Erreur: méthode de requête invalide.");
    }
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
    die;
}
?>
