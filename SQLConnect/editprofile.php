<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sustainablitymaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("1: Connection failed: " . $conn->connect_error);
}

$currentUsername = $_POST["currentUsername"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$newUsername = $_POST["username"];
$newPassword = $_POST["password"];

// Checks if the new username already exists (and isn't the same user)
$checkQuery = "SELECT * FROM users WHERE username = ? AND username != ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ss", $newUsername, $currentUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "3: Username already exists"; // meaans username already taken
    exit();
}

// Updates the user
$updateQuery = "UPDATE users 
SET firstname = ?, lastname = ?, username = ?, password = ?
WHERE username = ?";

$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("sssss", $firstname, $lastname, $newUsername, $newPassword, $currentUsername);

if ($stmt->execute()) {
    echo "0"; 
} else {
    echo "2"; // Update failed
}

$stmt->close();
$conn->close();

?>