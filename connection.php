<?php 
	session_start();
	$cn = mysqli_connect("localhost","root","","php_practise");

	if(!$cn) echo "You Are Not Connect To Database"; 
 ?>