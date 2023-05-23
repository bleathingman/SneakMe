<?php
require_once("../config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $password = $_POST["password"];

    // Insert user into the database
    $sql = "INSERT INTO users (username, email, status, password) VALUES ('$username', '$email', '$status', '$password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../users.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>