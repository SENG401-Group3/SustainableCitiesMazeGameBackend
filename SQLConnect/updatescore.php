<?php
$con = mysqli_connect('localhost', 'root', '', 'sustainablitymaze');

if (mysqli_connect_errno()) {
    echo "1: Connection failed";
    exit();
}

$username = $_POST["username"];
$points = intval($_POST["points"]);

// Increment score column
$query = "UPDATE users SET score = score + $points WHERE username = '" . mysqli_real_escape_string($con, $username) . "'";

if (mysqli_query($con, $query)) {
    echo "0: Score updated";
} else {
    echo "2: Update failed";
}
?>