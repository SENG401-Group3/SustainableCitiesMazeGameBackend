<?php

	$con = mysqli_connect('localhost', 'root', 'root', 'sustainablitymaze');

	// check connection
	if (mysqli_connect_errno())
	{
		echo "1: Connection failed";
		exit();
	}

	// fetch usernames and high scores from db
	$gethighscoresquery = "SELECT username, highscore FROM users ORDER BY highscore DESC;";
	$gethighscores = mysqli_query($con, $gethighscoresquery) or die("10: Get highscores query failed");

	// Process the result set
	if ($gethighscores->num_rows > 0)
	{
		echo "0\n";
		while($row = $gethighscores->fetch_assoc())
		{
			echo "Username: " . $row["username"] . "\tHigh score: " . $row["highscore"] . "\n";
		}
	}
	else
	{
		echo "11: No results found";
		exit();
	}

?>