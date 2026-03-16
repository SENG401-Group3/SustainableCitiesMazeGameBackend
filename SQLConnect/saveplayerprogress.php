<?php
    require_once 'db.php';

    $username = ($_POST["username"] ?? 0);
    $highscore = (int)($_POST["highScore"] ?? 0);
    $citynumber = (int)($_POST["cityNumber"] ?? 0);
    $currentscore = (int)($_POST["currentScore"] ?? 0);

    if ($username === "" || $citynumber <= 0) {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    // Validate city number to safely build the column name
    $allowedCities = [1, 2, 3, 4, 5];
    if (!in_array($citynumber, $allowedCities, true)) {
        echo "15: Invalid city number";
        $con->close();
        exit();
    }

    $query = "UPDATE users SET highscore = ?, citynumber = ?, currentscore = ?, WHERE username = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("iiis", $highscore, $citynumber, $currentscore, $username);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "0";
        } else {
            echo "4: No matching user found";
        }
    } else {
        echo "5: Save progress failed";
    }

    $stmt->close();
    $con->close();
?>
