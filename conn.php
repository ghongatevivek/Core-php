<?php 
	session_start();
	$cn=mysqli_connect("localhost","root","","demo");

	if(!$cn) echo "can't connect to database";
 ?>