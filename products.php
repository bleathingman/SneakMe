<?php
session_start();
require_once("config.php");
$conn = connectDB();

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
	exit;
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gestion des produits</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
	<?php require "templates/header.php"; ?>


	<div class="container" id="scroll">
		<h1>Gestion des produits</h1>

		<!-- Formulaire de création de produit -->
		<form class="form-product" action="gestion_produits/create_product.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<div>
					<label for="product_name">Nom du produit :</label>
					<input type="text" id="product_name" name="product_name" required>
				</div>
				<div>
					<label for="brand">Marque :</label>
					<input type="text" id="brand" name="brand" required>
				</div>
				<div>
					<label for="color">Couleur :</label>
					<input type="text" id="color" name="color" required>
				</div>
				<div>
					<label for="size">Taille :</label>
					<input type="text" id="size" name="size" required>
				</div>
				<div>
					<label for="price">Prix :</label>
					<input type="number" id="price" name="price" step="0.01" min="0" required>
				</div>
				<div>
					<label for="image">Image :</label>
					<input type="file" id="image" name="image" accept="image/*">
				</div>
			</div>
			<button class="btn btn-add" type="submit">Ajouter un produit</button>
		</form>
		<br>
		<!-- Tableau des produits -->
		<div class="scrollable">
			<table>
				<thead>
					<tr>
						<!-- <th>Id</th> -->
						<th>Image</th>
						<th>Nom du produit</th>
						<th>Marque</th>
						<th>Couleur</th>
						<th>Taille</th>
						<th>Prix</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// récupération des données de la table products
					$result = $conn->query("SELECT * FROM products");
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td><img src='gestion_produits/uploads/" . htmlspecialchars($row["image"]) . "' alt='Image du produit " . htmlspecialchars($row["product_name"]) . "' width='100'></td>";
						echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["brand"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["color"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["size"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
						echo "<td>";
						echo "<a class='btn btn-edit' href='gestion_produits/edit_product.php?id=" . htmlspecialchars($row["id"]) . "'>Modifier</a>";
						echo "<a class='btn btn-delete' href='gestion_produits/delete_product.php?id=" . htmlspecialchars($row["id"]) . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit ?\")'>Supprimer</a>";
						echo "</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>

</html>