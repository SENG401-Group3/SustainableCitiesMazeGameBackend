<?php

	$host = "localhost";
    $username = "root";
    $password = "root";
    $db_name = "sustainablitymaze";

    $con = mysqli_connect($host, $username, $password, $db_name);

	// check connection
	if (mysqli_connect_errno())
	{
		echo "1: Failed to connect to server";
		exit();
	}

	// fetch usernames and high scores from db
	$gethighscoresquery = "SELECT username, highscore FROM users ORDER BY highscore DESC;";
	$gethighscores = mysqli_query($con, $gethighscoresquery) or die("7: Get highscores query failed");

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
		echo "8: No results found";
		exit();
	}

?>