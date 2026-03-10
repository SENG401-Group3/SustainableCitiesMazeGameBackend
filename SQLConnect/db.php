<?php

	$host = "sustainabilitymazegame.mysql.database.azure.com";
	$username = "group03";
	$password = "MswGTMLvM?*x@w7";
	$db_name = "sustainabilitymazegame";

	$con = mysqli_init();
	mysqli_ssl_set($con, null, null, "/var/www/html/DigiCertGlobalRootCA.crt.pem", null, null);
	mysqli_real_connect($con, $host, $username, $password, $db_name, 3306);
	if (mysqli_connect_errno($con))
	{
		die("1: Failed to connect to server");
	}

	echo "0";

	mysqli_close($con);

?>