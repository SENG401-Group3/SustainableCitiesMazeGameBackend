<?php

	$host = "sustainabilitymazegame.mysql.database.azure.com";
	$username = "group03";
	$password = "MswGTMLvM?*x@w7";
	$db_name = "sustainabilitymazegame";
	$port = 3306;

	// certificate file should be inside the deployed app folder
	$ssl_ca = __DIR__ . "/../DigiCertGlobalRootG2.crt.pem";

	$con = mysqli_init();

	if (!$con) 
	{
		die("1: Failed to initialize MySQL connection");
	}

	mysqli_ssl_set($con, null, null, $ssl_ca, null, null);

	if (!mysqli_real_connect($con, $host, $username, $password, $db_name, $port, null, MYSQLI_CLIENT_SSL)) 
	{
		die("1: Failed to connect to server");
	}

	mysqli_set_charset($con, "utf8mb4");
?>