<?php

	$con = mysqli_connect('localhost', 'root', 'root', 'sustainablitymaze');

	// check connection
	if (mysqli_connect_errno())
	{
		echo "1: Connection failed";
		exit();
	}

	$email = $_POST["email"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$username = $_POST["username"];
	$password = $_POST["password"];

	// check if email alaready exists
	$emailcheckquery = "SELECT email FROM users WHERE email='" . $email . "';";

	$emailcheck = mysqli_query($con, $emailcheckquery) or die("2: Email check query failed");

	if (mysqli_num_rows($emailcheck) > 0)
	{
		echo "3: Email already exists";
		exit();
	}

	// check if username already exists
	$namecheckquery = "SELECT username FROM users WHERE username='" . $username . "';";

	$namecheck = mysqli_query($con, $namecheckquery) or die("4: Name check query failed");

	if (mysqli_num_rows($namecheck) > 0)
	{
		echo "5: Username already exists";
		exit();
	}

	// basic password security
	$salt = "\$5\$rounds=5000\$" . "electroplating" . $username . "\$";
	$hash = crypt($password, $salt);

	// add user to the table
	$insertuserquery = "INSERT INTO users (email, firstname, lastname, username, hash, salt) VALUES ('" . $email . "', '" . $firstname . "', '" . $lastname . "', '" . $username . "', '" . $hash . "', '" . $salt . "');";
	// $insertuserquery = "INSERT INTO users (username, hash, salt) VALUES ('" . $username . "', '" . $hash . "', '" . $salt . "');";
	mysqli_query($con, $insertuserquery) or die("6: Insert user query failed");

	echo "0";


?>
