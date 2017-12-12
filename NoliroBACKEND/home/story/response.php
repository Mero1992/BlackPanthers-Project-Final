
<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$styCls = new Story($connString); 

	switch($action) {
	 case 'add':
		$styCls->insertStory($params); /* functional */
	 break;
	 case 'edit':
		$styCls->updateStory($params); /* functional */
	 break;
	 case 'delete':
		$styCls->deleteStory($params); 
	 break;
	 default:
	 $styCls->getStorys($params); /* functional */
	 return;
	}
	
	class Story { 
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getStorys($params) { 
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertStory($params) { 
		$data = array();;
		$sql = "INSERT INTO `story` (storyTitle, storyType, storyLink, storyKeywords, storyDescription) VALUES('" . $params["title"] . "', '" . $params["storyType"] . "', '" . $params["link"] . "','" . $params["keywords"] . "','" . $params["description"] . "');  "; 
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert story data"); 
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {    
			$where .=" WHERE ";
			$where .=" ( storyTitle LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR storyType LIKE '".$params['searchPhrase']."%' "; 
			$where .=" OR storyLink LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR storyKeywords LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR storyDescription LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `story` "; 
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot storys data"); 
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch storys data"); 
		
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
	function updateStory($params) { /* edit_id/description/etc zu edit_storyID/etc. !!!!!!!!!!!!*/
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `story` set storyTitle = '" . $params["edit_storyTitle"] . "',storyType = '" . $params["edit_storyType"] . "', storyLink='" . $params["edit_storyLink"]."', storyKeywords='" . $params["edit_storyKeywords"] ."', storyDescription='" . $params["edit_storyDescription"] .  "' WHERE storyID='".$_POST["edit_storyID"]."'";/*!"storyID" war "id"!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update story data"); 
	}
	
	function deleteStory($params) { 
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `story` WHERE storyID='".$params["id"]."'"; /* "storyID" war "id"   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete story data");
	}
}
?>
	