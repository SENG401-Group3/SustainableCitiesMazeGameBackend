<?php
    require_once 'db.php';

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        echo json_encode(["error" => "2: Missing username or password"]);
        $con->close();
        exit();
    }

    $query = "SELECT id, firstname, lastname, username, password, pfp, highscore FROM users WHERE username = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo json_encode(["error" => "3: Failed to prepare statement"]);
        $con->close();
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        echo json_encode(["error" => "5: No user found"]);
        $stmt->close();
        $con->close();
        exit();
    }

    $row = $result->fetch_assoc();
    $storedHash = $row["password"];

    if (!password_verify($password, $storedHash)) {
        echo json_encode(["error" => "6: Incorrect password"]);
        $stmt->close();
        $con->close();
        exit();
    }

    $response = [
        "id" => (int)$row["id"],
        "firstname" => $row["firstname"],
        "lastname" => $row["lastname"],
        "username" => $row["username"],
        "pfp" => (int)$row["pfp"],
        "highscore" => (int)$row["highscore"]
    ];

    echo json_encode($response);

    $stmt->close();
    $con->close();
?>