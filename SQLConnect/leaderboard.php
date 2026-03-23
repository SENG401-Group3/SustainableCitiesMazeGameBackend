<?php
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    
    // Handle the "preflight" request from the browser
    if ($_SERVER['REQUEST_REQUEST'] == 'OPTIONS') {
        exit;
    }
	require_once 'db.php';

	// fetch usernames and high scores from db
	$query = "SELECT username, highscore FROM users ORDER BY highscore DESC, username ASC";
	$stmt = $con->prepare($query);

	if(!$stmt)
	{
		echo json_encode(["error" => "7: Failed to prepare statement"]);
		$con->close();
		exit();
	}

	$stmt->execute();
	$result = $stmt->get_result();

	// Process the result set
	if ($result->num_rows > 0)
	{
		$response = array(
			"username" => array(),
			"highscore" => array(),
			"error" => null
		);

		while($row = $result->fetch_assoc())
		{
			$response["username"][] = $row["username"];
			$response["highscore"][] = (int)$row["highscore"];
		}

		echo json_encode($response);
	}
	else
	{
		echo json_encode(["error" => "8: No users found"]);
	}

	$stmt->close();
	$con->close();

?>