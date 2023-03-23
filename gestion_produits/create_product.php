<?php
include "../config.php";

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
    echo "Erreur: méthode de requête invalide.";
}
