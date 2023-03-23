<?php
session_start();
require_once("config.php");

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hash);
    $result = $stmt->execute();

    if ($result) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Erreur lors de l'inscription. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h1>Inscription</h1>
    <?php if (isset($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="email">E-mail :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="S'inscrire">
    </form>
    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    <script src="assets/js/script.js"></script>
</body>

</html>