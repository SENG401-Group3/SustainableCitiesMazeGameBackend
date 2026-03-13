<?php
    // import the database connection
    require_once 'db.php';

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "")
    {
        echo "2: Missing username or password";
        //close the connection to the database
        $con->close();
        exit();
    }

    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = $con->prepare($query);

    if(!$stmt)
    {
        echo "3: Failed to prepare statement";
        $con->close();
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if($result->num_rows !== 1)
    {
        echo "5: No user found.";
        $stmt->close();
        $con->close();
        exit();
    }

    $row = $result->fetch_assoc();
    $storedHash = $row["password"];

    if(password_verify($password, $storedHash))
    {
        echo "0";
    }
    else
    {
        echo "6: Incorrect password";
    }

    $stemt->close();
    $con->close();
?>


