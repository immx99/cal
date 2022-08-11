<?php
    // $db=new mysqli('localhost','root','imMx010m','src');
    // $servername = "sql200.epizy.com";
	// $username = "epiz_27683464";
	// $password = "dkVDGAYvTRJt";
	// $dbname="epiz_27683464_src";

	$servername = "localhost";
	$username = "root";
	$password = "imMx010m";
	$dbname="src";

// 	$servername = "databases.000webhost.com";
    // $servername = "localhost";
	// $username = "id18252708_pngl";
	// $password = "X5JZDK8=V3H-R}|d";
	// $dbname="id18252708_src";

	$conn = new mysqli($servername, $username, $password, $dbname);
    // $db=new mysqli('sql200.epizy.com','epiz_27683464','imMx010m','epiz_27683464_src');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	  }
?>