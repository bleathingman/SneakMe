<?php
require_once("../config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $status = $_POST["status"];

    $sql = "UPDATE users SET username=?, email=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stmt->bind_param("sssi", $username, $email, $status, $id);
        } else {
            $stmt->bind_param("sssdi", $username, $email, $status, $id);
        }

        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../index.php");
}