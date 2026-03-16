<?php
    // import the database connection
    require_once 'db.php';

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "")
    {
        echo json_encode(["error" => "2: Missing username or password"]);
        //close the connection to the database
        $con->close();
        exit();
    }

    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = $con->prepare($query);

    if(!$stmt)
    {
        echo json_encode(["error" => "3: Failed to prepare statement"]);
        $con->close();
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if($result->num_rows !== 1)
    {
        echo json_encode(["error" => "5: No user found"]);
        $stmt->close();
        $con->close();
        exit();
    }

    $row = $result->fetch_assoc();
    $storedHash = $row["password"];

    if(!password_verify($password, $storedHash))
    {
        echo json_encode(["error" => "6: Incorrect password"]);
        $stmt->close();
        $con->close();
        exit();
    }

    $query = "SELECT id FROM users WHERE username = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $userId = $row["id"];
    
    $query = "SELECT city, score FROM users WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        echo json_encode(["error" => "7: User data not found."]);
        $stmt->close();
        $con->close();
        exit();
    }
    $progress = $result->fetch_assoc();

    echo json_encode($progress);

    $stmt->close();
    $con->close();
?>


