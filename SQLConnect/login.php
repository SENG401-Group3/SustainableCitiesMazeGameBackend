<?php

$con = mysqli_connect('localhost', 'root', '', 'sustainablitymaze');

if (mysqli_connect_errno())
{
    echo "1: Connection failed";
    exit();
}

$username = $_POST["username"];
$password = $_POST["password"];

$query = "SELECT password FROM users WHERE username='" . $username . "';";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) != 1)
{
    echo "7: No user found";
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
    echo "9: Incorrect password";
}
?>
