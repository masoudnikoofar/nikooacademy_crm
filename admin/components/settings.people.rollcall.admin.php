<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['rollcall_id']))
{
	$rollcall_id=$_GET['rollcall_id'];
}
if ($func2=="add")
{
	$popup_arguments=array("pid"=>"settings.people.rollcall.add&person_id=".$person_id);
	popup($popup_arguments);
}
else if ($func2=="delete")
{
	$db->query("delete from people_rollcall where id='$rollcall_id'");
	alert("با موفقیت حذف شد");
	goback("index.php?pid=settings.people&person_id=".$person_id."&func=rollcall");	
}
else if ($func2=="edit")
{
	$popup_arguments=array("pid"=>"settings.people.rollcall.edit&person_id=".$person_id."&rollcall_id=".$rollcall_id);
	popup($popup_arguments);
}
else if ($func2=="print")
{
	$popup_arguments=array("pid"=>"settings.people.rollcall.print&person_id=".$person_id."&date_from=".$_GET['date_from']."&date_to=".$_GET['date_to']);
	popup($popup_arguments);
}
else
{
	include("components/settings.people.rollcall.view.php");
}
?>