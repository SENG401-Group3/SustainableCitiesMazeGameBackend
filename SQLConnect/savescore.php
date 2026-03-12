<?php

    $con = mysqli_connect('localhost', 'root', '', 'sustainablitymaze');

    if (mysqli_connect_errno())
    {
        echo "1: Connection failed";
        exit();
    }

    $username = $_POST["username"];
    $score = intval($_POST["score"]);

    $savescorequery = "INSERT INTO users (username, highscore) VALUES ('" . $username . "', " . $score . ") ON DUPLICATE KEY UPDATE highscore = GREATEST(highscore, VALUES(highscore));";

    if (!mysqli_query($con, $savescorequery))
    {
        echo "14: Save failed";
        exit();
    }

    echo "0";

?>