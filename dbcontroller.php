<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = NULL;
	private $database = "bubbalab";
	
	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->selectDB($conn);
		}
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password);
		return $conn;
	}
	
	function selectDB($conn) {
		mysqli_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysqli_query($query,$conn);
		while($row=mysqli_fetch_array($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}
?>