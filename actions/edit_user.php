<?php
require_once("../config.php");
$conn = connectDB();

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modifier les informations</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php require "../templates/header.php"; ?>
    <div class="container">
        <h1>Modifier l'utilisateur</h1>

        <form class="form-edit-users" action="update_user.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="username">Message de l'utilisateur :</label>
                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" required>

                <label for="email">Message du chatbot :</label>
                <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>" required>

                <label for="status">Statut :</label>
                <input type="text" id="status" name="status" value="<?php echo $row['status']; ?>" required>
            </div>
            <input class="btn btn-success" type="submit" value="Mettre à jour">
        </form>

    </div>
    
</body>


</html>