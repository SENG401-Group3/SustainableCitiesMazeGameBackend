<?php
	require_once 'db.php'; 

	// Allow itch.io to access this script
    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    
    // Handle the "preflight" request from the browser
    if ($_SERVER['REQUEST_REQUEST'] == 'OPTIONS') {
        exit;
    }

	$username = trim($_POST["username"] ?? "");
	$newpassword = $_POST["newpassword"] ?? "";
	$confirmpassword = $_POST["confirmpassword"] ?? "";

	if ($username === "" || $newpassword === "" || $confirmpassword === "") {
		echo "2: Missing required fields";
		$con->close();
		exit();
	}

	if ($newpassword !== $confirmpassword) {
		echo "12: Password fields are non-matching";
		$con->close();
		exit();
	}

	// Make sure user exists
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

	if ($result->num_rows !== 1) {
		echo "5: No user found";
		$stmt->close();
		$con->close();
		exit();
	}
	$stmt->close();

	$hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

	$updateQuery = "UPDATE users SET password = ? WHERE username = ?";
	$stmt = $con->prepare($updateQuery);

	if (!$stmt) {
		echo "4: Update preparation failed";
		$con->close();
		exit();
	}

	$stmt->bind_param("ss", $hashedPassword, $username);

	if ($stmt->execute()) {
		echo "0";
	} else {
		echo "13: Reset password query failed";
	}

	$stmt->close();
	$con->close();
?>