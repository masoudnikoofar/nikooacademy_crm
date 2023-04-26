<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$db->query("select * from semesters where is_current=1");
$res=$db->result();
$row=$res[0];
$current_semester_id=$row['id'];


/*
$db->query("select 
a.id as student_id,
concat(a.firstname,' ',a.lastname) as student_fullname,
concat(g.firstname,' ',g.lastname) as teacher_fullname,
f.title as course_title,
d.max_class_date
from 
students a,
students_courses b,
students_courses_registrations c,
(select student_course_registration_id,max(class_date) as max_class_date from students_courses_schedules group by student_course_registration_id) d,
courses f,
teachers g
where 
1=1
and c.semester_id='".$current_semester_id."'
and a.id=b.student_id
and b.id=c.student_course_id
and b.course_id=f.id
and d.student_course_registration_id=c.id
and b.teacher_id=g.id
and a.inactive=0
and b.inactive=0
and c.id not in (select student_course_registration_id as schedules_count from students_courses_schedules where class_date >= '".$today."')
");

*/

$db->query("select 
a.id as student_id,
concat(a.firstname,' ',a.lastname) as student_fullname,
concat(g.firstname,' ',g.lastname) as teacher_fullname,
f.title as course_title,
d.max_class_date
from 
students a,
students_courses b,
(select x.student_course_id as student_course_id,max(y.class_date) as max_class_date from students_courses_registrations x,students_courses_schedules y
where x.id=y.student_course_registration_id group by x.student_course_id) d,
courses f,
teachers g
where 
1=1
and a.id=b.student_id
and b.id=d.student_course_id
and b.course_id=f.id
and d.student_course_id=b.id
and b.teacher_id=g.id
and a.inactive=0
and b.inactive=0
group by 
a.id,
concat(a.firstname,' ',a.lastname),
concat(g.firstname,' ',g.lastname),
f.title,
d.max_class_date
having d.max_class_date<'".$today."'
");
//and c.semester_id='".$current_semester_id."'
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="7">لیست دانشجویان فعالی که برنامه زمانبندی ندارند</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
		<td>آخرین تاریخ</td>
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
			<td><?php echo $row['max_class_date']; ?></td>
		</tr>
		<?php
	}
	?>
</table>