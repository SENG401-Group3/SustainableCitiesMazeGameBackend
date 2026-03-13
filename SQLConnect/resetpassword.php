<?php

	$con = mysqli_connect('localhost', 'root', 'root', 'sustainablitymaze');

	// check connection
	if (mysqli_connect_errno())
	{
		echo "1: Connection failed";
		exit();
	}

	$username = $_POST["username"];
	$newpassword = $_POST["newpassword"];
	$confirmpassword = $_POST["confirmpassword"];

	// Check if username already exists
    $namecheckquery = "SELECT username FROM users WHERE username='" . $username . "';";

    $namecheck = mysqli_query($con, $namecheckquery) or die("2: Name check query failed");

    if (mysqli_num_rows($namecheck) > 0)
    {
        echo "3: Username already exists";
        exit();
    }

    // Check if the password fields are matching
    if ($newpassword != $confirmpassword)
    {
    	echo "12: Password fields are non-matching";
    	exit();
    }
    else
    {
    	$hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
    	$resetpasswordquery = "UPDATE users SET password = '" . $hashedPassword . "' WHERE username = '" . $username . "';";

    	mysqli_query($con, $resetpasswordquery) or die("13: Reset password query failed");
    }

	echo "0";


?>
