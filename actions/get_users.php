<?php
// Vérifiez l'authentification et l'autorisation de l'utilisateur ici

$sql = "SELECT id, username, email, status FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    http_response_code(200);
    echo json_encode($users);
} else {
    http_response_code(404);
    echo json_encode(["error" => "No users found"]);
}

$conn->close();
