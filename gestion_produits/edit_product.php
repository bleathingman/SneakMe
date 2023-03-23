<?php
include "../config.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modifier le produit</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php require "../templates/header.php"; ?>
    <div class="container">
        <h1>Modifier le produit</h1>

        <form class="form" action="update_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="product_name">Nom du produit :</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo $row['product_name']; ?>" required>

                <label for="brand">Marque :</label>
                <input type="text" id="brand" name="brand" value="<?php echo $row['brand']; ?>" required>

                <label for="color">Couleur :</label>
                <input type="text" id="color" name="color" value="<?php echo $row['color']; ?>" required>

                <label for="size">Taille :</label>
                <input type="text" id="size" name="size" value="<?php echo $row['size']; ?>" required>

                <label for="price">Prix :</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $row['price']; ?>" required>

                <label for="image">Image actuelle :</label>
                <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" width="100">
                <br>
                <label for="image">Nouvelle image :</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <input class="btn btn-success" type="submit" value="Mettre à jour">
        </form>

    </div>

</body>

</html>