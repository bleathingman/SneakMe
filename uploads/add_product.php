<?php
require_once 'config.php';

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupération des données du formulaire
  $name = $_POST['name'];
  $brand = $_POST['brand'];
  $color = $_POST['color'];
  $size = $_POST['size'];
  $price = $_POST['price'];
  $image = $_POST['image'];

  // Insertion du produit dans la base de données
  $sql = "INSERT INTO products (name, brand, color, size, price, image) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssds", $name, $brand, $color, $size, $price, $image);
  $stmt->execute();

  header("Location: products.php");
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteProduct($id);
  }
}
