<?php

    $host = "localhost";
    $username = "root";
    $password = "root";
    $db_name = "sustainablitymaze";

    $con = mysqli_connect($host, $username, $password, $db_name);

    if (mysqli_connect_errno())
    {
        echo "1: Failed to connect to server";
        exit();
    }

    $username = $_POST["username"];
    $usernameclean = filter_var($username, FILTER_SANITIZE_STRING);
    $password = $_POST["password"];

    if ($usernameclean != $username)
    {
        die("-1: Invalid characters in input. Possible SQL Injection attempt");
    }

    $query = "SELECT password FROM users WHERE username='" . $usernameclean . "';";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) != 1)
    {
        echo "5: No user found";
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $storedHash = $row["password"];

    if (password_verify($password, $storedHash))
    {
        echo "0";
    }
    else
    {
        echo "6: Incorrect password";
    }

?>
