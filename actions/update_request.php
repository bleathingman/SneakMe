<?php
require_once("../config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $user_message = $_POST["user_message"];
    $bot_message = $_POST["bot_message"];
    $description = $_POST["description"];

    $sql = "UPDATE request_chat SET user_message=?, bot_message=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stmt->bind_param("sssi", $user_message, $bot_message, $description, $id);
        } else {
            $stmt->bind_param("sssi", $user_message, $bot_message, $description, $id);
        }

        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../index.php");
}
