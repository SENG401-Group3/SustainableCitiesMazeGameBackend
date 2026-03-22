<?php
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
		while($row = $result->fetch_assoc())
		{
			$response = [
				"username" => $row["username"],
				"highscore" => (int)$row["highscore"]
			];
			echo json_encode($response);
		}
	}
	else
	{
		echo json_encode(["error" => "8: No users found"]);
	}

	$stmt->close();
	$con->close();

?>