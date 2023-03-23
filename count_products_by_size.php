<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["size"])) {
    $size = $_POST["size"];

    $sql = "SELECT COUNT(*) as count FROM products WHERE size = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row["count"];
    } else {
        echo 0;
    }
}
