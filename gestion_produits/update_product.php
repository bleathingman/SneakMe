<?php
require_once("../config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $product_name = $_POST["product_name"];
    $brand = $_POST["brand"];
    $color = $_POST["color"];
    $size = $_POST["size"];
    $price = $_POST["price"];
    $image = $_FILES["image"]["name"];

    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $sql = "UPDATE products SET product_name=?, brand=?, color=?, size=?, price=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdsi", $product_name, $brand, $color, $size, $price, $image, $id);
    } else {
        $sql = "UPDATE products SET product_name=?, brand=?, color=?, size=?, price=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdi", $product_name, $brand, $color, $size, $price, $id);
    }

    $stmt->execute();
    header("Location: ../products.php");
} else {
    echo "Erreur: méthode de requête invalide.";
}
