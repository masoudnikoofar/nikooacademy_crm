<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<table class="tables" width="100%">
	<tr class="tablesheader">
		<td>اطلاعات ناقص moodle</td>
	</tr>
	<tr>
		<td valign="top"><?php include("components/reports.moodle.incomplete_data.php"); ?></td>
		<td valign="top"><?php include("components/homepage.active.students.chart.php"); ?></td>
		<td valign="top">
			<?php include("components/homepage.students.debtors.warning.php"); ?>
			<br/>
			<?php include("components/homepage.students.active_and_schedule_less.php"); ?>
		</td>
	</tr>
	<tr>
		<td colspan="3" valign="top"><?php include("components/reports.students.debtors.php"); ?></td>
	</tr>
</table>




<?php
/*
$timetable_popup_arguments=array(
	"pid"=>"homepage.courses.schedule"
);
timetable_popup($timetable_popup_arguments);
*/
?>