<?php
require_once("../config.php");
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $user_message = $_POST["user_message"];
    $bot_message = $_POST["bot_message"];

    $sql = "UPDATE request_chat SET user_message=?, bot_message=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stmt->bind_param("ssi", $user_message, $bot_message, $id);
        } else {
            $stmt->bind_param("ssdi", $user_message, $bot_message, $id);
        }

        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../index.php");
}
