<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST['step']=="2")
{	
	$tel=$db->mysql_real_escape_string($_POST[tel]);
	$mobile=$db->mysql_real_escape_string($_POST[mobile]);
	$firstname=$db->mysql_real_escape_string($_POST[firstname]);
	$lastname=$db->mysql_real_escape_string($_POST[lastname]);

	if ($firstname=="" || $lastname=="")
	{
		alert("تکمیل فیلد های ستاره دار الزامی است");
	}
	else
	{
		$db->query("insert into buyers set 
			tel='$tel',
			mobile='$mobile',
			firstname='$firstname',
			lastname='$lastname',
			operator_id='$operator_id'
		");
			
		alert("ثبت با موفقیت انجام شد");
		goback("index.php?pid=buyers");
	}
}		

include("buyers.add.step1.php");
?>	