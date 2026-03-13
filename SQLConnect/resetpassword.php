<?php

	// $host = "localhost";
    // $username = "root";
    // $password = "root";
    // $db_name = "sustainablitymaze";

    // $con = mysqli_connect($host, $username, $password, $db_name);

    // if (mysqli_connect_errno())
    // {
    //     echo "1: Failed to connect to server";
    //     exit();
    // }

    require_once 'db.php';

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
