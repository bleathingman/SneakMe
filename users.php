<?php
session_start();
require_once("config.php");
$conn = connectDB();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Les balises meta, title, et autres... -->
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <div class="container">
        <h1>Gestion des utilisateurs</h1>

        <!-- Formulaire de création d'utilisateur -->
        <form class="form" action="actions/create_user.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div>
                    <label for="id">ID :</label>
                    <input type="text" id="id" name="id" required>
                </div>
                <div>
                    <label for="username">Nom de l'utilisateur :</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="email">Email :</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div>
                    <label for="user_statut">Statut :</label>
                    <input type="text" id="user_statut" name="user_statut" required>
                </div>
            </div>
            <input class="btn btn-xp" type="submit" value="Ajouter un utilisateur">
        </form>
        <br>
        <div class="container">
            <h1>Users</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["username"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <script src="assets/js/script.js"></script>
    </div>
</body>

</html>