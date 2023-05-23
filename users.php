<?php
require_once("config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $password = $_POST["password"];

    // Insert user into the database
    $sql = "INSERT INTO users (id, username, email, status, password) VALUES ('$id', '$username', '$email', '$status', '$password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../users.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE id = '$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: $_SERVER[PHP_SELF]");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE id = '$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: $_SERVER[PHP_SELF]");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
</head>

<body>
    <?php require 'templates/header.php'; ?>
    <div class="container">
        <h1>Utilisateurs</h1>

        <!-- Formulaire pour ajouter un nouvel utilisateur -->
        <form class="form-user" action="actions/create_user.php" method="post">
            <div class="form-group">
                <label for="id">ID :</label>
                <input type="text" id="id" name="id" required>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                    <!-- Bouton déroulant pour choisir le statut -->
                    <label for="status">Statut :</label>
                    <select id="status" name="status">
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                    </select>
                </div>
                <input class="btn btn-add" type="submit" value="Ajouter un utilisateur">
            </form>

            <!-- Tableau pour afficher les utilisateurs existants -->
            <div class="scrollable">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $user) {
                            echo "<tr>";
                            echo "<td>" . $user["id"] . "</td>";
                            echo "<td>" . $user["username"] . "</td>";
                            echo "<td>" . $user["email"] . "</td>";
                            echo "<td>" . $user["status"] . "</td>";
                            echo "<td>";
                            echo "<a class='btn btn-edit' href='actions/edit_user.php?id=" . $user["id"] . "' onclick='openEditModal(event)'>Modifier</a>";
                            echo "<a class='btn btn-delete' href='?delete_id=" . $user["id"] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\")'>Supprimer</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <input class="btn btn-add" type="submit" value="Ajouter un utilisateur">
        </form>
        <br>
        <!-- Tableau pour afficher les utilisateurs existants -->
        <div class="scrollable">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user["id"] . "</td>";
                        echo "<td>" . $user["username"] . "</td>";
                        echo "<td>" . $user["email"] . "</td>";
                        echo "<td>" . $user["status"] . "</td>";
                        echo "<td>";
                        echo "<a class='btn btn-delete' href='?delete_id=" . $user["id"] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\")'>Supprimer</a>";
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