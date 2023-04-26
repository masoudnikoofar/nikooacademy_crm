<?php
session_start();
include_once("../config/config.php");
if (0)
{
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
?>
<head>
<link href="../scripts/timetable/bootstrap.css" rel="stylesheet">
<link href="../scripts/timetable/tribal-bootstrap.css" rel="stylesheet">
<link href="../scripts/timetable/tribal-timetable.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../scripts/calendar/CSS/calendar.css">

<title><?php echo TITLE; ?></title>
<script src="../scripts/timetable/ga.js" async="" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/timetable/jquery-latest.js"></script>
<script type="text/javascript" src="../scripts/timetable/jquery.js"></script>
<script type="text/javascript" src="../scripts/timetable/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="../scripts/timetable/bootstrap-collapse.js"></script>
<script type="text/javascript" src="../scripts/timetable/tribal.js"></script>
<script type="text/javascript" src="../scripts/timetable/tribal-shared.js"></script>
<script type="text/javascript" src="../scripts/timetable/tribal-timetable.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/calendar/JScripts/amin.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/calendar/JScripts/calendar.js"></script>
<link rel="shortcut icon" href="../images/favicon.ico">
</head>
<?php
    include_once("../classes/class_database.php");   
    include_once("../functions/functions1.php");
	include_once("../classes/jdatetime.class.php");   
    include_once("../functions/date.php");
    $db=new database();

    
    $jdate = new jDateTime(false,true,'Asia/Tehran');
    
	$today = jDateTime::date("Y-m-d", time());
	$day_split=preg_split('%-%',$today);
    $today_year=$day_split[0];
    $today_month=$day_split[1];
    $today_day=$day_split[2];
	$today_time = jDateTime::date("H:i:s", time());
    
	$operator_id=$_SESSION['admin.'.$company_name_en.'_user_id'];
		
	include("components/".$_GET['pid'].".php");
?>