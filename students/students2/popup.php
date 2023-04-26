<?php
session_start();
include_once("../config/config.php");
//error_reporting(E_ALL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo TITLE; ?></title>
<link href="../styles/admin.css" rel="stylesheet">
<link href="../styles/customers.invoice.print_official01.css" rel="stylesheet">

<script type="text/javascript" language="JavaScript" src="../scripts/calendar/JScripts/amin.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/calendar/JScripts/calendar.js"></script>
<script type="text/javascript" language="JavaScript" src="../scripts/jquery-2.0.0.js"></script>
<link rel="stylesheet" type="text/css" href="../scripts/calendar/CSS/calendar.css">
<link rel="shortcut icon" href="../images/favicon.ico">
</head>
<?php
    include_once("../classes/class_database.php");   
    include_once("../functions/functions.php");
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