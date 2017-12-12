<?php
Class dbObj{
	/* Database connection start */
	var $servername = "localhost";
	var $username = "ourstories";
	var $password = "ourstories";
	var $dbname = "tietojenkasittely_ourstories";
	var $conn;
	function getConnstring() {
		$con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
        mysqli_set_charset($con,"utf8"); //This is needed when using ä,ö,å etc chars in JSON for example

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $con;
		}
		return $this->conn;
	}
}

?>