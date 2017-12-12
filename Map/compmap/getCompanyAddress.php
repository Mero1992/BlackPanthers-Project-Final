<?php
/*
	file:	getCompanyAddress.php
	desc:	Gets the company address from db
*/
if(!empty($_GET['area'])) $area=$_GET['area'].'%%';else $area='%%';
include('db.php');
$sql="SELECT companyName,street,city,website FROM company WHERE city LIKE '$area'";
$result = $conn->query($sql);
$JSONstring='{"companies":[';

$x=0;
while($row = $result->fetch_assoc()) {
	$JSONstring.='{';
	$JSONstring.='"Companyname":';
	$JSONstring.='"'.$row['companyName'].'",';
	$JSONstring.='"Street":';
	$JSONstring.='"'.$row['street'].'",';
	$JSONstring.='"City":';
	$JSONstring.='"'.$row['city'].'",';
	$JSONstring.='"Web":';
	$JSONstring.='"'.$row['website'].'"';
	$x++;
	if($result->num_rows>$x) $JSONstring.='},';else $JSONstring.='}';
}
$conn->close();  

$JSONstring.=']}';
//return JSON
echo $JSONstring;
?>