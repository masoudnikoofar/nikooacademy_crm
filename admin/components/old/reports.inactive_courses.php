<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php

$db->query("select 
a.id as student_id,
concat(a.firstname,' ',a.lastname) as student_fullname,
concat(g.firstname,' ',g.lastname) as teacher_fullname,
f.title as course_title
from 
students a,
students_courses b,
courses f,
teachers g
where a.id=b.student_id
and b.course_id=f.id
and b.teacher_id=g.id
and b.inactive=1
");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="4">لیست دوره های غیرفعال</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><a href="index.php?pid=students&student_id=<?php echo $row['student_id']; ?>&func=courses" target="_blank"><?php echo $row['student_fullname']; ?> (<?php echo $row['student_id']; ?>)</a></td>
			<td><?php echo $row['course_title']; ?></td>
			<td><?php echo $row['teacher_fullname']; ?></td>
		</tr>
		<?php
	}
	?>
</table>