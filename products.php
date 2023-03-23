<?php
session_start();
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
	exit;
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Products</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<?php require 'templates/header.php'; ?>
	<h1>Products</h1>

	<!-- Add product form -->
	<h2>Ajouter un produit</h2>
	<?php if (isset($error)) : ?>
		<p class="error"><?php echo $error; ?></p>
	<?php endif; ?>
	<?php if (isset($success)) : ?>
		<p class="success"><?php echo $success; ?></p>
	<?php endif; ?>
	<form action="products.php" method="post">
		<label for="brand">Marque :</label>
		<input type="text" name="brand" id="brand" required>
		<br>
		<label for="product_name">Nom du produit :</label>
		<input type="text" name="product_name" id="product_name" required>
		<br>
		<label for="price">Prix :</label>
		<input type="number" step="0.01" name="price" id="price" required>
		<br>
		<label for="size">Taille :</label>
		<input type="text" name="size" id="size" required>
		<br>
		<label for="color">Couleur :</label>
		<input type="text" name="color" id="color" required>
		<br>
		<label for="image">Image:</label>
		<input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required>
		<input type="submit" value="Ajouter">
	</form>

	<!-- Display products -->
	<h2>Liste des produits</h2>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Image</th>
				<th>Marque</th>
				<th>Nom du produit</th>
				<th>Prix</th>
				<th>Taille</th>
				<th>Couleur</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($result->num_rows > 0) : ?>
				<?php while ($row = $result->fetch_assoc()) : ?>
					<tr>
						<td class="id_product"><?php echo $row["id"]; ?></td>
						<td class="image_product"><img src="<?php echo $row['image']; ?>"></td>
						<td class="brand_product"><?php echo $row["brand"]; ?></td>
						<td class="name_product"><?php echo $row["product_name"]; ?></td>
						<td class="price_product"><?php echo $row["price"]; ?> €</td>
						<td class="size_product"><?php echo $row["size"]; ?></td>
						<td class="color _product"><?php echo $row["color"]; ?></td>
					</tr>
				<?php endwhile; ?>
			<?php else : ?>
				<tr>
					<td colspan="6">Aucun produit trouvé.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<script src="assets/js/script.js"></script>
</body>

</html>