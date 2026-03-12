<?php

$con = mysqli_connect('localhost', 'root', '', 'sustainablitymaze');

// Check connection
if (mysqli_connect_errno())
{
    echo "1: Connection failed";
    exit();
}

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$username = $_POST["username"];
$password = $_POST["password"];

// Check if username already exists
$namecheckquery = "SELECT username FROM users WHERE username='" . $username . "';";

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
                    VALUES ('" . $firstname . "', '" . $lastname . "', '" . $username . "', '" . $hashedPassword . "');";

mysqli_query($con, $insertuserquery) or die("4: Insert user query failed");

//initiailize city progress for new user
$getuseridquery = "SELECT id FROM users WHERE username='" . $username . "';";
$getuserid = mysqli_query($con, $getuseridquery) or die("5: Get user ID query failed");

if (mysqli_num_rows($getuserid) != 1)
{
    echo "6: User not found after insertion";
    exit();
}

$row = mysqli_fetch_assoc($getuserid);
$userid = $row["id"];

$initializeprogressquery = "UPDATE users SET city=0, score=0 WHERE id=" . $userid . ";";
mysqli_query($con, $initializeprogressquery) or die("7: Initialize progress query failed");

echo "0"; // success

?>
