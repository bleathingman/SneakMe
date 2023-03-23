<?php
require_once 'config.php';

// Vérification de l'envoi du fichier
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
  // Vérification de la taille du fichier
  if ($_FILES['image']['size'] <= 1000000) {
    // Vérification de l'extension du fichier
    $info = pathinfo($_FILES['image']['name']);
    $extension = $info['extension'];
    $allowed_extensions = array('jpg', 'jpeg', 'png');

    if (in_array($extension, $allowed_extensions)) {
      // Enregistrement du fichier
      move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . basename($_FILES['image']['name']));
      
      // Enregistrement du produit dans la base de données
      $name = $_POST['name'];
      $brand = $_POST['brand'];
      $color = $_POST['color'];
      $size = $_POST['size'];
      $price = $_POST['price'];
      $image = 'uploads/' . basename($_FILES['image']['name']);

      $sql = "INSERT INTO products (name, brand, color, size, price, image) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssds", $name, $brand, $color, $size, $price, $image);
      $stmt->execute();

      header("Location: products.php");
    } else {
      echo "Extension du fichier non autorisée. Seules les extensions jpg, jpeg et png sont acceptées.";
    }
  } else {
    echo "La taille du fichier est trop grande. La taille maximale autorisée est de 1 Mo.";
  }
} else {
  echo "Erreur lors de l'envoi du fichier.";
}
