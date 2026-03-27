<?php
    require_once 'db.php';
    
    // Allow itch.io to access this script
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    
    // Handle the preflight request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit;
    }
    
    $currentUsername = trim($_POST["currentUsername"] ?? "");
    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $newUsername = trim($_POST["username"] ?? "");
    $newPassword = $_POST["password"] ?? "";
    //$confirmPassword = $_POST["confirmPassword"] ?? "";
    
    if ($currentUsername === "") {
        echo "2: Missing current username";
        $con->close();
        exit();
    }
    
    // Get current user data first
    $selectQuery = "SELECT firstname, lastname, username FROM users WHERE username = ?";
    $stmt = $con->prepare($selectQuery);
    
    if (!$stmt) {
        echo "3: Failed to prepare user lookup";
        $con->close();
        exit();
    }
    
    $stmt->bind_param("s", $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows !== 1) {
        echo "4: User not found";
        $stmt->close();
        $con->close();
        exit();
    }
    
    $currentData = $result->fetch_assoc();
    $stmt->close();
    
    // Use old values if fields are blank
    $finalFirstname = ($firstname !== "") ? $firstname : $currentData["firstname"];
    $finalLastname = ($lastname !== "") ? $lastname : $currentData["lastname"];
    $finalUsername = ($newUsername !== "") ? $newUsername : $currentData["username"];
    
    // If username changed, check if it already exists
    if ($finalUsername !== $currentUsername) {
        $checkQuery = "SELECT username FROM users WHERE username = ?";
        $stmt = $con->prepare($checkQuery);
    
        if (!$stmt) {
            echo "5: Failed to prepare username check";
            $con->close();
            exit();
        }
    
        $stmt->bind_param("s", $finalUsername);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            echo "6: Username already exists";
            $stmt->close();
            $con->close();
            exit();
        }
    
        $stmt->close();
    }
    
    // Handle password only if user entered one
    if ($newPassword !== "") {
        if ($newPassword === "") {
            echo "7: Password is required";
            $con->close();
            exit();
        }
    
        /*if ($newPassword !== $confirmPassword) {
            echo "8: Passwords do not match";
            $con->close();
            exit();
        }*/
    
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        $updateQuery = "UPDATE users SET firstname = ?, lastname = ?, username = ?, password = ? WHERE username = ?";
        $stmt = $con->prepare($updateQuery);
    
        if (!$stmt) {
            echo "9: Failed to prepare update with password";
            $con->close();
            exit();
        }
    
        $stmt->bind_param("sssss", $finalFirstname, $finalLastname, $finalUsername, $hashedPassword, $currentUsername);
    } else {
        $updateQuery = "UPDATE users SET firstname = ?, lastname = ?, username = ? WHERE username = ?";
        $stmt = $con->prepare($updateQuery);
    
        if (!$stmt) {
            echo "10: Failed to prepare update";
            $con->close();
            exit();
        }
    
        $stmt->bind_param("ssss", $finalFirstname, $finalLastname, $finalUsername, $currentUsername);
    }
    
    if ($stmt->execute()) {
        echo "0";
    } else {
        echo "11: Update failed";
    }
    
    $stmt->close();
    $con->close();
?>