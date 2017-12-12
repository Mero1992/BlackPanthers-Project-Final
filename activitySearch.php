<?php
/*
	file:	ourstories_example/activitySearch.php
	desc:	Returns the list of activities as JSON
*/
header("Access-Control-Allow-Origin: * "); //all the UIs can access
if(!empty($_GET['search'])) $search=$_GET['search'].'%%';else $search='';
include('db.php');
$sql="SELECT * FROM activity
	WHERE activity.activityName LIKE '$search%%'";
$result = $conn->query($sql);
$output=array();
while($row=$result->fetch_assoc()){
	$output[]=$row;
}
if(!empty($search)) echo json_encode($output);
?>