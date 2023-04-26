<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$db->query("select * from students where moodle_user_id is null");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="4">دانشجویان</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>کد دانشجو</td>
		<td>موبایل</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['mobile'];?></td>
		</tr>
		<?php
	}
	?>	
</table>
<hr/>
<?php
$db->query("select * from teachers where moodle_user_id is null");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="4">اساتید</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام استاد</td>
		<td>کد استاد</td>
		<td>موبایل</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['mobile'];?></td>
		</tr>
		<?php
	}
	?>	
</table>
<hr/>
<?php
$db->query("select * from courses_categories where moodle_category_id is null");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="4">گروه های دروس</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام گروه</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['title']; ?></td>
		</tr>
		<?php
	}
	?>	
</table>
<hr/>
<?php
$db->query("select * from courses where moodle_course_id is null");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="4">دروس</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام درس</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['title']; ?></td>
		</tr>
		<?php
	}
	?>	
</table>
<hr/>
<?php
$db->query("select c.title as course_title,b.firstname as student_firstname,b.lastname as student_lastname from courses_students a,students b,courses c where a.course_id=c.id and a.student_id=b.id and a.moodle_enrolment_id is null");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="4">انشجویان دروس</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام درس</td>
		<td>نام دانشجو</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['course_title']; ?></td>
			<td><?php echo $row['student_firstname']." ".$row['student_lastname']; ?></td>
		</tr>
		<?php
	}
	?>	
</table>