<?php
    require_once 'db.php';

    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    echo "step1\n";

    if ($firstname === "" || $lastname === "" || $username === "" || $password === "") {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    echo "step2\n";

    $checkQuery = "SELECT username FROM users WHERE username = ?";
    $stmt = $con->prepare($checkQuery);

    if (!$stmt) {
        echo "step3_failed_prepare_check";
        $con->close();
        exit();
    }

    echo "step3\n";

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
    echo "step4\n";

    // Secure password hashing (modern method)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    echo "step5\n";

    $insertQuery = "INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($insertQuery);

    if (!$stmt) {
        echo "step6_failed_prepare_insert";
        $con->close();
        exit();
    }

    echo "step6\n";

    $stmt->bind_param("ssss", $firstname, $lastname, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "step7_failed_execute_insert";
    }

    $stmt->close();
    $con->close();
?>
