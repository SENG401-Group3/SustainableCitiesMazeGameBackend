<?php
header('Content-Type: application/json');

$con = mysqli_connect('localhost', 'root', '', 'sustainablitymaze');

if (mysqli_connect_errno()) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$username = $_POST["username"];

$getuser = "SELECT firstname, lastname, username, score FROM users WHERE username='" . mysqli_real_escape_string($con, $username) . "'";

$result = mysqli_query($con, $getuser);

if (mysqli_num_rows($result) != 1) {
    echo json_encode(["error" => "No user found"]);
    exit();
}

$row = mysqli_fetch_assoc($result);

echo json_encode($row);
?>