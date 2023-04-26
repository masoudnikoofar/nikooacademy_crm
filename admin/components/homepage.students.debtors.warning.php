<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$db->query("select * from semesters where is_current=1");
$res=$db->result();
$row=$res[0];
$current_semester_id=$row['id'];



$db->query("select 
a.id as student_id,
concat(a.firstname,' ',a.lastname) as student_fullname,
concat(g.firstname,' ',g.lastname) as teacher_fullname,
f.title as course_title,
d.schedules_count
from 
students a,
students_courses b,
(select y.student_course_id,count(*) as schedules_count from  students_courses x,students_courses_registrations y,students_courses_schedules z where
x.id=y.student_course_id and y.id=z.student_course_registration_id and z.class_date > '".$today."' group by y.student_course_id having count(*)<3) d,
courses f,
teachers g
where
a.id=b.student_id
and b.id=d.student_course_id
and b.course_id=f.id
and b.teacher_id=g.id
and b.inactive=0
and a.inactive=0
order by 2
");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="7">لیست دانشجویانی که تا 2 جلسه دیگر باید ثبت نام کنند</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
		<td>تعداد جلسات آینده</td>
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
			<td><?php echo $row['schedules_count']; ?></td>
		</tr>
		<?php
	}
	?>
</table>