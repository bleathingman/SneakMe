<?php
require_once("../config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $status = $_POST["user_statut"];

    // Insert user into the database
    $sql = "INSERT INTO users (id, username, email, status) VALUES ('$id', '$username', '$email', '$status')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../users.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>