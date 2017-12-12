<?php

	 $DBhost = "localhost";
	 $DBuser = "ourstories";
	 $DBpass = "ourstories";
	 $DBname = "tietojenkasittely_ourstories";
	 
	 $conn = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($conn->connect_errno) {
         die("ERROR : -> ".$conn->connect_error);
     }
