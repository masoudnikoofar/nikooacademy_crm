<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($func2=="print")
{
	$popup_arguments=array(
		"pid"=>"teachers.payments.print&teacher_id=".$teacher_id."&semester_id=".$_GET['semester_id']."&class_date_month=".$_GET['class_date_month'],
		"parent_redirect"=>true,
		"parent_redirect_url"=>"index.php?pid=teachers&teacher_id=".$teacher_id."&func=payments"
	);
	popup($popup_arguments);
}
else if ($func2=="extra_info")
{
	$popup_arguments=array(
		"pid"=>"teachers.payments.extra_info&teacher_id=".$teacher_id."&semester_id=".$_GET['semester_id']."&class_date_month=".$_GET['class_date_month'],
		"parent_redirect"=>true,
		"parent_redirect_url"=>"index.php?pid=teachers&teacher_id=".$teacher_id."&func=payments"
	);
	popup($popup_arguments);
}
else
	include("components/teachers.payments.view.php");
?>