<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$actCls = new Activity($connString); 

	switch($action) {
	 case 'add':
		$actCls->insertActivity($params); /* functional */
	 break;
	 case 'edit':
		$actCls->updateActivity($params); /* functional */
	 break;
	 case 'delete':
		$actCls->deleteActivity($params); 
	 break;
	 default:
	 $actCls->getActivitys($params); /* functional */
	 return;
	}
	
	class Activity { 
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getActivitys($params) { 
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertActivity($params) { 
		$data = array();;
		$sql = "INSERT INTO `activity` (activityName, activityDescription, activityKeyword) VALUES('" . $params["name"] . "', '" . $params["description"] . "','" . $params["keyword"] . "');  "; 
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert activity data"); 
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {    
			$where .=" WHERE ";
			$where .=" ( activityName LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR activityDescription LIKE '".$params['searchPhrase']."%' ";

			$where .=" OR activityKeyword LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `activity` "; 
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot activitys data"); 
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch activitys data"); 
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"            => intval($params['current']), 
			"rowCount"            => 10, 			
			"total"    => intval($qtot->num_rows),
			"rows"            => $data   // total data array
			);
		
		return $json_data;
	}
	function updateActivity($params) { /* edit_name/description/etc zu edit_activityName/etc. !!!!!!!!!!!!*/
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `activity` set activityName = '" . $params["edit_activityName"] . "', activityDescription='" . $params["edit_activityDescription"]."', activityKeyword='" . $params["edit_activityKeyword"] . "' WHERE activityID='".$_POST["edit_activityID"]."'";/*!"activityID" war "id"!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update activity data"); 
	}
	
	function deleteActivity($params) { 
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `activity` WHERE activityID='".$params["id"]."'"; /* "activityID" war "id"   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete activity data");
	}
}
?>
	