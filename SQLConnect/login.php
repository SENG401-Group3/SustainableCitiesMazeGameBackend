<?php

	$con = mysqli_connect('localhost', 'root', 'root', 'sustainablitymaze');

	// check connection
	if (mysqli_connect_errno())
	{
		echo "1: Connection failed";
		exit();
	}

	$username = $_POST["username"];
	$password = $_POST["password"];

	// check if username already exists
	$namecheckquery = "SELECT username, salt, hash, score FROM users WHERE username='" . $username . "';";

	$namecheck = mysqli_query($con, $namecheckquery) or die("4: Name check query failed");

	if (mysqli_num_rows($namecheck) != 1)
	{
		if (mysqli_num_rows($namecheck) == 0)
		{
			echo "7: No user with name exists";
		}
		else
		{
			echo "8: Multiple users with the same name exist";	// should not happen but just to be safe
		}
		exit();
	}

	// get login info from query
	$logininfo = mysqli_fetch_assoc($namecheck);
	$salt = $logininfo["salt"];
	$hash = $logininfo["hash"];

	$loginhash = crypt($password, $salt);
	if ($hash != $loginhash)
	{
		echo "9: Incorrect password";
		exit();
	}

	echo "0\t" . $logininfo["score"];

?>