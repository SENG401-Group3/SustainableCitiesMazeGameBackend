<?php
    require_once 'db.php';

    $userid = (int)($_POST["userid"] ?? 0);
    $citynumber = trim($_POST["citynumber"] ?? "");
    $score = (int)($_POST["score"] ?? 0);

    if ($userid <= 0 || $citynumber === "") {
        echo "2: Missing required fields";
        $con->close();
        exit();
    }

    // Validate city number to safely build the column name
    $allowedCities = ["1", "2", "3", "4", "5"];
    if (!in_array($citynumber, $allowedCities, true)) {
        echo "15: Invalid city number";
        $con->close();
        exit();
    }

    $cityColumn = "city" . $citynumber . "score";

    // Dynamic column name is safe here because city number was validated strictly
    $query = "UPDATE users SET $cityColumn = ? WHERE id = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo "3: Query preparation failed";
        $con->close();
        exit();
    }

    $stmt->bind_param("ii", $score, $userid);

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
