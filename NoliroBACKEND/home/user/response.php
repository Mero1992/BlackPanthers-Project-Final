<?php
    session_start();
	//include connection file 
	include_once("../connection.php");
    
    $userRow=$_SESSION['priv'];    

	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$userCls = new User($connString); 

	switch($action) {
	 case 'add':
		$userCls->insertUser($params); /* functional */
	 break;
	 case 'edit':
		$userCls->updateUser($params); /* functional */
	 break;
	 case 'delete':
		$userCls->deleteUser($params); 
	 break;
	 default:
	 $userCls->getUsers($params); /* functional */
	 return;
	}
	
	class User { 
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getUsers($params) { 
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertUser($params) { //---------------------------------------------------------------------------
		$data = array();;
		$sql = "INSERT INTO `user` (email, password, firstname, lastname, phone, level) VALUES('" . $params["email"] . "', '" . $params["password"] . "','" . $params["firstname"] . "','" . $params["lastname"] . "','" . $params["phone"] . "','" . $params["level"] . "');  "; 
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert user data"); 
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {    
			$where .=" WHERE ";
			$where .=" ( email LIKE '".$params['searchPhrase']."%' ";
            
			$where .=" OR password LIKE '".$params['searchPhrase']."%' ";

			$where .=" OR firstname LIKE '".$params['searchPhrase']."%' ";
            
            $where .=" OR lastname LIKE '".$params['searchPhrase']."%' ";
            
            $where .=" OR phone LIKE '".$params['searchPhrase']."%' ";
            
            $where .=" OR level LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search -----------------------------------------------------
		$sql = "SELECT * FROM `user` "; 
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot users data"); 
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch users data"); 
		
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
	function updateUser($params) { /* edit_name/description/etc zu edit_userName/etc. !!!!!!!!!!!!*/
        
		global $userRow;
        
        if($userRow['level'] == 'editor'){
            echo "<script type='text/javascript'>alert('No privilege!')</script>";
        }
        elseif($userRow['level'] == 'admin' ){ //|| $userRow['userID'] == $params["edit_userID"]
        $data = array();
		//print_R($_POST);die;
		$sql = "Update `user` set email = '" . $params["edit_email"] . "', password='" . $params["edit_password"]."', firstname='" . $params["edit_firstname"] .  "', lastname='" . $params["edit_lastname"] .  "', phone='" . $params["edit_phone"] .  "', level='" . $params["edit_level"] .  "' WHERE userID='".$_POST["edit_userID"]."'";/*!"userID" war "id"!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update user data"); 
        }
        
        
	}
	
	function deleteUser($params) { 
        
        global $userRow;
        
		if($userRow['level'] == 'admin'){
        echo "<script type='text/javascript'>alert('No privilege!')</script>";
        $data = array();
		//print_R($_POST);die;
		$sql = "delete from `user` WHERE userID='".$params["id"]."'"; /* "userID" war "id"   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete user data");
        }elseif($userRow['level'] == 'editor'){
            echo "<script type='text/javascript'>alert('No privilege!')</script>";
        }
	}
}
?>
	