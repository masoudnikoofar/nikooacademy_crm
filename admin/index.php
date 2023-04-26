<?php
session_start();
include_once("../config/config.php");
if (0)
{
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
set_time_limit(0);

include_once("../classes/class_database.php");   
include_once("../classes/jdatetime.class.php");
require_once('../classes/MoodleRest.php');   
include_once("../functions/functions.php");
include_once("../functions/date.php");
require '../classes/vendor/autoload.php';

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo TITLE; ?></title>
<script type="text/javascript" language="JavaScript" src="../scripts/calendar/JScripts/amin.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/calendar/JScripts/calendar.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/jquery-2.0.0.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/highcharts.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/exporting.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/autocomplete.js"></script>

<link rel="stylesheet" type="text/css" href="../scripts/calendar/CSS/calendar.css">

<link href="../styles/admin.css" rel="stylesheet">
<link href="../styles/login.css" rel="stylesheet">



<link rel="shortcut icon" href="../images/favicon.ico">
<!--
<?php
    
    $db = new database();
	$db->query("SET @@sql_mode= 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");

	$MoodleRest = new MoodleRest('https://lms.nikoo-academy.com/webservice/rest/server.php', '846427e87bc64639d03770a655165df6');
	$jdate = new jDateTime(false,true,'Asia/Tehran');
    $today = $jdate->date("Y-m-d", time());
	$today_time = jDateTime::date("H:i:s", time());
	
	$today_datetime = $today." ".$today_time;
	
	require_once '../classes/nusoap/nusoap/nusoap.php';
	date_default_timezone_set("Asia/Tehran");

	$client = new nusoap_client('http://new.payamsms.com/services/?wsdl', true);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	
    $limit=10;//lists limit!
?>
-->

</head>
<body marginheight="0" marginwidth="0">                  
<?php         
	if (isset($_GET['func']))
	{
		$func=$_GET['func'];
	}
	if (isset($_GET['func2']))
	{
		$func2=$_GET['func2'];
	}
	if (isset($_GET['func3']))
	{
		$func3=$_GET['func3'];
	}
	
	
	

	
	
	include_once("login.php");
?>
</body>
</html>
