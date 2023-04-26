<?php
class database
{
	var $conn;
	var $result = "res";
	var $_q;
	var $resNum;
//	var $show_mysqli_query = false;
	public function __construct($host='',$username='',$password='',$dbname='',$char_set='') 
	{
 		if (!$host) 
		{
		   	$this->host = DB_HOST;
			$this->username = DB_USERNAME;
			$this->password = DB_PASSWORD;
			$this->dbname = DB_DBNAME;
			$this->char_set = DB_CHAR_SET;
			//$this->char_set = '';
		}
		else
		{
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->char_set = $char_set;
		}
		
		$this->conn = mysqli_connect($this->host, $this->username, $this->password);
		
		if(!$this->conn)
			$this->sendError("Error: Could not connect to database.");
		if (!@mysqli_select_db($this->conn,$this->dbname))
			$this->sendError("Error: Could not select database."); 
		if ($this->char_set)
		{
			if (!mysqli_set_charset($this->conn,$this->char_set)) 
			{
				//printf("Error loading character set utf8: %s\n", $this->conn->error);
			}
		}
	}
	function sendError ($err,$query='') {
		if (!$query) {
			$query = 'No Query.';
		}
		echo( "$err<br /><b>Query:</b> $query<br /><b>mySql says:</b> ".mysqli_error($this->conn) );
		die;
	}
	function reset_pointer() {
		@mysqli_data_seek($this->result,0);
	}
	
	function query($q, $show_mysqli_query=0) {
		$this->result = @mysqli_query($this->conn,$q);
		$this->_q = $q;
		
		if(mysqli_error($this->conn)){
			$this->sendError("Could not perform Query",$q);
		}
	}
	function numRows() {
		return mysqli_num_rows($this->result);
	}
	function makeResult() {
		global $result_num;
		$result_num = $this->numRows();
		$this->resNum = $this->numRows();
		$this->resArray = $this->resArrayAssoc = array();
		if ($result_num) {
			$i = 0;
			while ($row = mysqli_fetch_row($this->result)) {
				$this->resArray[$i] = $row;
				++$i;
			}
			$this->reset_pointer();
			$i = 0;
			while ($assoc = mysqli_fetch_assoc($this->result)) {
				$this->resArrayAssoc[$i] = $assoc;
				++$i;
			}
		}
	}
	function getResult($field='0',$row='0') {
		$return = @mysqli_result($this->result,$row,$field);
		$this->reset_pointer();
		return $return;
	}
	function getResultArray($n=NULL) {
		$this->makeResult();
		if ($n !== NULL) {
			return $this->resArray[$n];
		}
		return $this->resArray;
	}
	function result($n=NULL) {
		$this->makeResult();
		if ($n !== NULL) {
			return $this->resArrayAssoc[$n];
		}
		return $this->resArrayAssoc;
	}
	
	function close() {
		return (mysqli_close($this->conn));
	}
	
	function lastInsertId() {
		$db = new Connection;
		$db->query("select last_insert_id() as id");
		return $db->getResult('id');
	}
	
	function mysql_real_escape_string($string)
	{
			return mysqli_real_escape_string($this->conn,$string);
	}
}
?>
