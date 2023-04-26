<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php 
$fid=$db->mysql_real_escape_string($_GET['fid']);
if (is_file("components/reports.".$fid.".php"))
{
	include("reports.".$fid.".php");
}
else
{
?>                                
<table width="100%" class="tables">
	<tr>
		<td align="center"><a href="index.php?pid=reports&fid=students.debtors"><img src="../images/buttons/debtor.png" border="0"><br />دانشجویان بدهکار</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=moodle.incomplete_data"><img src="../images/buttons/moodle.png" border="0"><br />اطلاعات ناقص moodle</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=income"><img src="../images/buttons/income_chart.png" border="0"><br />هزینه / درآمد</a></td>
		<td align="center"><a href="timetable.php?pid=reports.courses.schedule" target="_blank"><img src="../images/buttons/schedule.png" border="0"><br />برنامه زمانبندی ترم ها</a></td>	
	</tr>
    <tr>
		<td align="center"><a href="index.php?pid=reports&fid=students"><img src="../images/buttons/students.png" border="0"><br />لیست دانشجوها</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=active_students_semester"><img src="../images/buttons/students.png" border="0"><br />لیست دانشجوهای فعال هر ترم</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=inactive_courses"><img src="../images/buttons/inactive_courses.png" border="0"><br />لیست دوره های غیر فعال</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=students_payments"><img src="../images/buttons/students_payments.png" border="0"><br />پرداخت های دانشجویان</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=students.debtors"><img src="../images/buttons/debtor.png" border="0"><br />دانشجویان بدهکار</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=students.off"><img src="../images/buttons/students_with_off.png" border="0"><br />دانشجویانی که تخفیف دارند</a></td>
	</tr>
    <tr>
		<td align="center"><a href="index.php?pid=reports&fid=students.goods"><img src="../images/buttons/goods.png" border="0"><br />لیست کالاهای دانشجوها</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=students.goods.chart_01"><img src="../images/buttons/goods_chart.png" border="0"><br />نمودار کالاهای دانشجوها</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=income_per_season"><img src="../images/buttons/income_chart.png" border="0"><br />نمودار درآمد هر فصل</a></td>
		<td align="center"><a href="index.php?pid=reports&fid=income_per_month"><img src="../images/buttons/income_chart.png" border="0"><br />نمودار درآمد هر ماه</a></td>
	</tr>
</table>
<?php
}
?>