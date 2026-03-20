<?php
    require_once 'db.php';

    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($firstname === "" || $lastname === "" || $username === "" || $password === "") {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    $checkQuery = "SELECT username FROM users WHERE username = ?";
    $stmt = $con->prepare($checkQuery);

    if (!$stmt) {
        echo "3. Failed to prepare statement";
        $con->close();
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "4: Username already exists";
        $stmt->close();
        $con->close();
        exit();
    }

    $stmt->close();

    // Secure password hashing (modern method)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertQuery = "INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($insertQuery);

    if (!$stmt) {
        echo "3. Failed to prepare statement";
        $con->close();
        exit();
    }

    $stmt->bind_param("ssss", $firstname, $lastname, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "4. Failed to execute insert statement";
    }

    $stmt->close();
    $con->close();
?>
