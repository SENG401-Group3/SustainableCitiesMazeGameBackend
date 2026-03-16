<?php
    require_once 'db.php';

    $username = trim($_POST["username"] ?? "");
    $points = (int)($_POST["points"] ?? 0);

    if ($username === "") {
        echo "2: Missing username";
        $con->close();
        exit();
    }

    // Increment score column
    $query = "UPDATE users SET score = score + ? WHERE username = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) 
    {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("is", $points, $username);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "0: Score updated";
        } else {
            echo "4: No matching user found";
        }
    } else {
        echo "5: Update failed";
    }

    $stmt->close();
    $con->close();
?>