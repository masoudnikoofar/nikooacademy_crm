<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$db->query("select c.firstname,c.lastname,d.title as course_title,e.title as semester_title,a.tuition_fee,a.tuition_fee_per_session from students_courses_registrations a,students_courses b, students c , courses d,semesters e
where 
a.student_course_id=b.id
and b.student_id=c.id
and b.course_id=d.id
and a.semester_id=e.id
order by e.id,a.tuition_fee_per_session desc
");
$res=$db->result();

?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>ترم</td>
		<td>شهریه</td>
		<td>شهریه هر جلسه</td>
	</tr>
	<?php
	foreach ($res as $row)
	{
		$i=1;
	?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
		<td><?php echo $row['course_title']; ?></td>
		<td><?php echo $row['semester_title']; ?></td>
		<td><?php echo $row['tuition_fee']; ?></td>
		<td><?php echo $row['tuition_fee_per_session']; ?></td>
	</tr>
	<?php
	}
	?>
	
</table>
