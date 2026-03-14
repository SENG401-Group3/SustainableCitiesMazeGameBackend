<?php
    // import database connection settings
    require_once 'db.php';

    // remove whitespace and check for special characters to prevent SQL Injection
    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($firstname === "" || $lastname === "" || $username === "" || $password === "")
    {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    // Check if username already exists
    $checkQuery = "SELECT username FROM users WHERE username = ?";
    $stmt = $con->prepare($checkQuery); 

    if (!$stmt) {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        echo "4: Username already exists";
        $stmt->close();
        $con->close();
        exit();
    }
    $stmt->close();

    // Secure password hashing (modern method)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user 
    // assumes score starts at 0
    $insertuserquery = "INSERT INTO users (firstname, lastname, username, password, score)
                        VALUES (?, ?, ?, ?, 0)";
    $stmt = $con->prepare($insertuserquery);

    if (!$stmt) {
        echo "5: Insert preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("ssss", $firstname, $lastname, $username, $hashedPassword);

    if($stmt->execute()) {
        echo "0"; // success
    } else {
        echo "6: Insert user query failed";
    }

    $stmt->close();
    $con->close();
?>
