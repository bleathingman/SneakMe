<?php
require_once("../config.php");
$conn = connectDB();

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM request_chat WHERE id = $id");
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
        <h1>Modifier la requête</h1>

        <form class="form-edit-request" action="update_request.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="user_message">Message de l'utilisateur :</label>
                <input type="text" id="user_message" name="user_message" value="<?php echo $row['user_message']; ?>" required>

                <label for="bot_message">Message du chatbot :</label>
                <input type="text" id="bot_message" name="bot_message" value="<?php echo $row['bot_message']; ?>" required>
                
                <label for="description">Description de la commande :</label>
                <input type="text" id="description" name="description" value="<?php echo $row['description']; ?>" required>
            </div>
            <input class="btn-success" type="submit" value="Mettre à jour">
        </form>

    </div>

</body>

</html>