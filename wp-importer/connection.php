<?php

// connection file to perform any extra activity.
$db_name= DB_NAME;

/** MySQL database username */
$db_user = DB_USER;

/** MySQL database password */
$db_password = DB_PASSWORD;

/** MySQL hostname */
$db_host= DB_HOST;


$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);

// Check connection
 if (mysqli_connect_errno($con))
   {
   $connection_msg= "Failed to connect to MySQL: " . mysqli_connect_error();
   }
  else
  	{
	 $connection_msg= "Connected successfully to Database! <br>"; 
	}
?>
