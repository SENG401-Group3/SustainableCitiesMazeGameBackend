<?php
	require_once 'db.php';

    $username = trim($_POST["username"] ?? "");

    if ($username === "") {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    $getuseridquery = "SELECT id FROM users WHERE username = ?";
    $stmt = $con->prepare($getuseridquery);
    if (!$stmt) {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "4: User not found";
        $stmt->close();
        $con->close();
        exit();
    }

    $row = $result->fetch_assoc();
    $userid = $row["id"];

    $getprogressquery = "SELECT score, citynumber FROM progress WHERE id = ?";
    $stmt = $con->prepare($getprogressquery);
    if (!$stmt) {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("i", $userid);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "4: Progress not found";
        $stmt->close();
        $con->close();
        exit();
    }

    $row = $result->fetch_assoc();
    $score = $row["score"];
    $citynumber = $row["citynumber"];

    echo "0\n";
    echo "Score: " . $score . "\tCity number: " . $citynumber . "\n";
    $stmt->close();
    $con->close();
    
?>