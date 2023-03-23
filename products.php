<?php
session_start();
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
	exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gestion des produits</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
	<?php require "templates/header.php"; ?>
	<div class="container">
		<h1>Gestion des produits</h1>

		<!-- Formulaire de création de produit -->
		<form class="form" action="gestion_produits/create_product.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="product_name">Nom du produit :</label>
				<input type="text" id="product_name" name="product_name" required>
				<label for="brand">Marque :</label>
				<input type="text" id="brand" name="brand" required>
				<label for="color">Couleur :</label>
				<input type="text" id="color" name="color" required>
				<label for="size">Taille :</label>
				<input type="text" id="size" name="size" required>
				<label for="price">Prix :</label>
				<input type="number" id="price" name="price" step="0.01" min="0" required>
				<label for="image">Image :</label>
				<input type="file" id="image" name="image" accept="image/*">
				<input class="btn btn-primary" type="submit" value="Ajouter un produit">
			</div>
		</form>

		<!-- Tableau des produits -->
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
					// echo "<td>" . $row["id"] . "</td>";
					echo "<td><img src='gestion_produits/uploads/" . $row["image"] . "' alt='" . $row["product_name"] . "' width='100'></td>";
					echo "<td>" . $row["product_name"] . "</td>";
					echo "<td>" . $row["brand"] . "</td>";
					echo "<td>" . $row["color"] . "</td>";
					echo "<td>" . $row["size"] . "</td>";
					echo "<td>" . $row["price"] . "</td>";
					echo "<td>";
					echo "<a href='gestion_produits/edit_product.php?id=" . $row["id"] . "'>Modifier</a> | ";
					echo "<a href='gestion_produits/delete_product.php?id=" . $row["id"] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit ?\")'>Supprimer</a>";
					echo "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
		</main>
	</div>
</body>

</html>