<?php
    header('Content-Type: application/json');
    require_once 'db.php';

    $username = trim($_POST["username"] ?? "");

    if ($username === "") {
        echo json_encode(["error" => "Missing username"]);
        $con->close();
        exit();
    }

    $query = "SELECT id, firstname, lastname, username, currentscore FROM users WHERE username = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo json_encode(["error" => "Query preparation failed"]);
        $con->close();
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        echo json_encode(["error" => "No user found"]);
        $stmt->close();
        $con->close();
        exit();
    }

    $row = $result->fetch_assoc();
    echo json_encode($row);

    $stmt->close();
    $con->close();
?>