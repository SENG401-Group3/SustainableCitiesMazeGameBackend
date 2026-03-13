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
    $citynumber = $_POST["citynumber"];
    $score = $_POST["score"];
    $speedboosts = $_POST["speedboosts"];

    $getuseridquery = "SELECT id FROM users WHERE username='" . $username . "';";
    $getuserid = mysqli_query($con, $getuseridquery) or die("12: Get user ID query failed");

    if (mysqli_num_rows($getuserid) != 1)
    {
        echo "13: User not found";
        exit();
    }

    $row = mysqli_fetch_assoc($getuserid);
    $userid = $row["id"];

    $updateprogressquery = "UPDATE users SET city" . $citynumber . "score=" . $score . ", speedboosts=" . $speedboosts . " WHERE id=" . $userid . ";";
    mysqli_query($con, $updateprogressquery) or die("14: Update progress query failed");

    echo "0"; // success

?>