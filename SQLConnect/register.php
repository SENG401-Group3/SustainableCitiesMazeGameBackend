<?php

    $host = "sustainabilitymazegame.mysql.database.azure.com";
	$username = "group03";
	$password = "MswGTMLvM?*x@w7";
	$db_name = "sustainabilitymazegame";

    $con = mysqli_connect($host, $username, $password, $db_name);

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "1: Failed to connect to server";
        exit();
    }

    $firstname = mysqli_real_escape_string($con, $_POST["firstname"]);
    $firstnameclean = filter_var($firstname, FILTER_SANITIZE_STRING);
    $lastname = mysqli_real_escape_string($con, $_POST["lastname"]);
    $lastnameclean = filter_var($lastname, FILTER_SANITIZE_STRING);
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $usernameclean = filter_var($username, FILTER_SANITIZE_STRING);
    $password = $_POST["password"];

    if ($firstnameclean != $firstname || $lastnameclean != $lastname || $usernameclean != $username)
    {
        echo "-1: Invalid characters in input. Possible SQL Injection attempt";
        exit();
    }

    // Check if username already exists
    $namecheckquery = "SELECT username FROM users WHERE username='" . $usernameclean . "';";

    $namecheck = mysqli_query($con, $namecheckquery) or die("2: Name check query failed");

    if (mysqli_num_rows($namecheck) > 0)
    {
        echo "3: Username already exists";
        exit();
    }

    // Secure password hashing (modern method)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insertuserquery = "INSERT INTO users (firstname, lastname, username, password)
                        VALUES ('" . $firstnameclean . "', '" . $lastnameclean . "', '" . $usernameclean . "', '" . $hashedPassword . "');";

    mysqli_query($con, $insertuserquery) or die("4: Insert user query failed");

    echo "0"; // success

?>
