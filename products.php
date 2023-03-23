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

<body class="row">
	<?php require 'templates/header.php'; ?>
	<div class="container-fluid py-5">
		<div class="row">
			<main class="col-lg-12">
				<div class="form">
					<h1>Products</h1>
					<!-- Add product form -->
					<h2>Ajouter un produit</h2>
					<?php if (isset($error)) : ?>
						<p class="error"><?php echo $error; ?></p>
					<?php endif; ?>
					<?php if (isset($success)) : ?>
						<p class="success"><?php echo $success; ?></p>
					<?php endif; ?>
					<form method="post" enctype="multipart/form-data" action="add_product.php">
						<label>Nom :</label>
						<input type="text" name="name" required>
						<br>
						<label>Marque :</label>
						<input type="text" name="brand" required>
						<br>
						<label>Couleur :</label>
						<input type="text" name="color" required>
						<br>
						<label>Taille :</label>
						<input type="text" name="size" required>
						<br>
						<label>Prix :</label>
						<input type="number" name="price" min="0" step="0.01" required>
						<br>
						<label>Image :</label>
						<input type="text" name="image" required>
						<br>
						<button type="submit">Ajouter</button>
					</form>

				</div>
				<!-- Display products -->
				<div>
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
								<th>Actions</th>
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
										<td>
											<form action="" method="post">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
												<button type="submit" name="delete">Supprimer</button>
											</form>
										</td>
									</tr>
								<?php endwhile; ?>
							<?php else : ?>
								<tr>
									<td colspan="6">Aucun produit trouvé.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</main>
		</div>
	</div>

	<script src="assets/js/script.js"></script>
</body>

</html>