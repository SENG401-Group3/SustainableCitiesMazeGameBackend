<?php
    require_once 'db.php';

    $currentUsername = trim($_POST["currentUsername"] ?? "");
    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $newUsername = trim($_POST["username"] ?? "");
    $newPassword = $_POST["password"] ?? "";

    if ($currentUsername === "" || $firstname === "" || $lastname === "" || $newUsername === "" || $newPassword === "") {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    // Check if new username belongs to another user
    $checkQuery = "SELECT username FROM users WHERE username = ? AND username != ?";
    $stmt = $con->prepare($checkQuery);

    if (!$stmt) {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("ss", $newUsername, $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "4: Username already exists";
        $stmt->close();
        $con->close();
        exit();
    }
    $stmt->close();

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE users SET firstname = ?, lastname = ?, username = ?, password = ? WHERE username = ?";
    $stmt = $con->prepare($updateQuery);

    if (!$stmt) {
        echo "5: Update preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("sssss", $firstname, $lastname, $newUsername, $hashedPassword, $currentUsername);

    if ($stmt->execute()) {
        echo "0";
    } else {
        echo "6: Update failed";
    }

    $stmt->close();
    $con->close();
?>