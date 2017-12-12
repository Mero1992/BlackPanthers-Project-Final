<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$cmpCls = new Company($connString);

	switch($action) {
	 case 'add':
		$cmpCls->insertCompany($params);
	 break;
	 case 'edit':
		$cmpCls->updateCompany($params);
	 break;
	 case 'delete':
		$cmpCls->deleteCompany($params);
	 break;
	 default:
	 $cmpCls->getCompanys($params);
	 return;
	}
	
	class Company {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getCompanys($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertCompany($params) {
		$data = array();;
		$sql = "INSERT INTO `company` (companyName, street, postnr, city, description, website, facebook) VALUES('" . $params["companyName"] . "', '" . $params["street"] . "','" . $params["postnr"] . "', '" . $params["city"] . "', '" . $params["description"] . "', '" . $params["website"] . "', '" . $params["facebook"] . "');  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert company data");
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE "; 
			$where .=" ( companyName LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR street LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR postnr LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR city LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR description LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR website LIKE '".$params['searchPhrase']."%' ";
            $where .=" OR facebook LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `company` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot companys data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch companys data");
		
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
	function updateCompany($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `company` set companyName = '" . $params["edit_companyName"] . "', street = '" . $params["edit_street"] . "', postnr='" . $params["edit_postnr"] . "', city='" . $params["edit_city"] . "', description='" . $params["edit_description"] . "', website='" . $params["edit_website"] . "', facebook='" . $params["edit_facebook"] . "' WHERE companyID='".$_POST["edit_companyID"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update company data");
	}
	
	function deleteCompany($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `company` WHERE companyID='".$params["id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete company data");
	}
}
?>
	