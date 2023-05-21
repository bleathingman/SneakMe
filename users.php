<?php
require_once("config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $status = $_POST["status"];

    // Insert user into the database
    $sql = "INSERT INTO users (id, username, email, status) VALUES ('$id', '$username', '$email', '$status')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../users.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <!-- Les balises meta, title, et autres... -->
</head>

<body>
<?php require 'templates/header.php'; ?>
    <div class="container-fluid py-5">
        <div class="container">
            <h1>Utilisateurs</h1>

            <!-- Formulaire pour ajouter un nouvel utilisateur -->
            <form class="form" action="actions/create_user.php" method="post">
                <div class="form-group">
                    <label for="id">ID :</label>
                    <input type="text" id="id" name="id" required>
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" required>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>

                    <!-- Bouton déroulant pour choisir le statut -->
                    <label for="status">Statut :</label>
                    <select id="status" name="status">
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                    </select>

                    <input class="btn btn-xp" type="submit" value="Ajouter l'utilisateur">
                </div>
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
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>