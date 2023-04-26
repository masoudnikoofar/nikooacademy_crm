<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($func2=="print")
{
	$popup_arguments=array(
		"pid"=>"settings.people.payments.print&person_id=".$person_id."&semester_id=".$_GET['semester_id']."&month=".$_GET['month'],
		"parent_redirect"=>true,
		"parent_redirect_url"=>"index.php?pid=settings&person_id=".$person_id."&func=payments"
	);
	popup($popup_arguments);
}
else if ($func2=="extra_info")
{
	$popup_arguments=array(
		"pid"=>"settings.people.payments.extra_info&person_id=".$person_id."&month=".$_GET['month'],
		"parent_redirect"=>true,
		"parent_redirect_url"=>"index.php?pid=settings&person_id=".$person_id."&func=payments"
	);
	popup($popup_arguments);
}
else
	include("components/settings.people.payments.view.php");
?>