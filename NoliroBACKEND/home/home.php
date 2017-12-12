<?php
session_start();
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: ../index.php");
}

$query = $conn->query("SELECT * FROM user WHERE userID=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <title>Welcome - <?php echo $userRow['email']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="dist/bootstrap.min.css" type="text/css" media="all">
        <link href="dist/jquery.bootgrid.css" rel="stylesheet" />
        <link href="home.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
</head>
<body>   
    	<!--Nav bar-->
			<div class="nav-top">
				<a href="home.php"><strong>Home</strong></a>
                <span class="right">
                <a href="activity/index.php"><strong>Activity</strong></a>
				<a href="company/index.php"><strong>Company</strong></a>
                <a href="community/index.php"><strong>Community</strong></a>
                <a href="story/index.php"><strong>Story</strong></a> 
                <a href="user/index.php"><strong>User</strong></a>
		        <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></span>
			</div>
        <!--Nav bar -->
    <div class="page-head"><h1>Noliro - Administration View</h1></div>
<ul class="items">
	<li>
		<a href="activity/index.php">
			<div class="content">
				<h2>Activity</h2>
			</div>
		</a>
	</li>
	<li>	
		<a href="company/index.php">
			<div class="content">
				<h2>Company</h2>
                </div>
		</a>
	</li>
	<li>
		<a href="community/index.php">
			<div class="content">
				<h2>Community</h2>
			</div>
		</a>
	</li>
    <li>
		<a href="story/index.php">
			<div class="content">
				<h2>Story</h2>
                </div>
		</a>
	</li>
    <li>
		<a href="user/index.php">
			<div class="content">
				<h2>User</h2>
			</div>
		</a>
	</li>
</ul>    
</body>
</html>