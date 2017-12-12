<?php
/*
	file:	db.php
	desc:	Creating the database connection to ourstories db
*/
$db_server='localhost';	//name or address to database server
$db_name='tietojenkasittely_ourstories';   //name of database used
$db_user='ourstories';   //username of database specified user
$db_password='ourstories'; //password for username

//create connection to database with mysqli-object
$conn=new mysqli($db_server,$db_user,$db_password,$db_name);
if($conn->connect_error){
	//if error in connection, stop running and display error message
	die('Database connection was not available.'.$conn->connect_error);
}
//set characters to be used in retrieving and saving data in database
mysqli_set_charset($conn,"utf8");
?>









