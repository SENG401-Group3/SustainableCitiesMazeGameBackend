<?php
	// Use Azure App Service environment variables if available,
	// otherwise fall back to hardcoded values for testing.
	$host = getenv("DB_HOST") ?: "sustainabilitymazegame.mysql.database.azure.com";
	$username = getenv("DB_USER") ?: "group03";
	$password = getenv("DB_PASS") ?: "MswGTMLvM?*x@w7";
	$db_name = getenv("DB_NAME") ?: "sustainabilitymazegame";
	$port = (int)(getenv("DB_PORT") ?: 3306);

	// certificate file should be inside the deployed app folder
	$ssl_ca = __DIR__ . "/../DigiCertGlobalRootG2.crt.pem";

	$con = mysqli_init();

	if (!$con) 
	{
		die("1: Failed to initialize MySQL connection");
	}

	mysqli_ssl_set($con, null, null, $ssl_ca, null, null);

	if (!mysqli_real_connect(
		$con, 
		$host, 
		$username, 
		$password, 
		$db_name, 
		$port, 
		null, 
		MYSQLI_CLIENT_SSL)) 
	{
		die("1: Failed to connect to server");
	}

	mysqli_set_charset($con, "utf8mb4");
?>