<?php
/*
	file:	ourstories_example/companySearch.php
	desc:	Returns the list of companies as JSON
*/
header("Access-Control-Allow-Origin: * "); //all the UIs can access
if(!empty($_GET['search'])) $search=$_GET['search'].'%%';else $search='';
include('db.php');
$sql="SELECT story.storyID, story.storyTitle, story.storyType, story.storyLink, story.storyKeywords, story.storyDescription, community.communityName FROM story
	RIGHT JOIN storyarea
	ON story.storyID=storyarea.storyID
	JOIN community
	ON storyarea.communityID=community.communityID
    WHERE community.communityName LIKE '$search%%'";
$result = $conn->query($sql);
$output=array();
while($row=$result->fetch_assoc()){
	$output[]=$row;
}
if(!empty($search)) echo json_encode($output);
?>


