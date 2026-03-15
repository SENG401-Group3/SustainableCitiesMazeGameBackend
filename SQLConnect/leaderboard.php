<?php
	require_once 'db.php';

	// fetch usernames and high scores from db
	$gethighscoresquery = "SELECT username, highscore FROM users ORDER BY highscore DESC, username ASC";
	$result = mysqli_query($con, $gethighscoresquery);;

	if(!$result)
	{
		echo "7: Get leaderboard query failed";
		$con->close();
		exit();
	}
	// Process the result set
	if ($result->num_rows > 0)
	{
		echo "0\n";
		while($row = $result->fetch_assoc())
		{
			echo "Username: " . $row["username"] . "\tHigh score: " . $row["highscore"] . "\n";
		}
	}
	else
	{
		echo "8: No results found";
	}

	$con->close();

?>