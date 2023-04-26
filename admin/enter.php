<?php
session_start();
//error_reporting(E_ALL);
include_once("../config/config.php");
include_once("../classes/class_database.php");  
$db = new database();
if ($_POST['status']<>"")
{
	$status=$db->mysql_real_escape_string($_POST['status']); 
	$db->query("update settings set status='".$status."'");
	echo "ok";
}
$db->query("select status from settings");
$res=$db->result();
echo $res[0]['status'];
?>	
<form method="post">
status:<input type="text" name="status"> 0 = ok
<button type="submit">send</button>
</form>