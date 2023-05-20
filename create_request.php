<?php
session_start();
require_once("config.php");
$conn = connectDB();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_message = $_POST["user_message"];
    $bot_message = $_POST["bot_message"];

    // Insert request into the database
    $sql = "INSERT INTO request_chat (user_message, bot_message) VALUES ('$user_message', '$bot_message')";
    if ($conn->query($sql) === TRUE) {
        header("Location: chatbot_requests.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>