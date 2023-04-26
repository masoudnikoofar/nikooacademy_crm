<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<form method="post">
	<select name="semester_id">
		<?php
		$db->query("select * from semesters");
		$res=$db->result();
		foreach ($res as $row)
		{
			$selected="";
			if ($row['is_current']=="1") $selected="selected";
			?>
			<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['title']; ?></option>
			<?php
		}
		?>
	</select>
	<button type="submit">نمایش</button>
</form>
<?php
if (isset($_POST['semester_id']))
{
	$semester_id=$db->mysql_real_escape_string($_POST['semester_id']);
}
else
{
	$db->query("select * from semesters where is_current='1'");
	$res=$db->result();
	$row=$res[0];
	$semester_id=$row['id'];
}

$db->query("select 
concat(a.firstname,' ',a.lastname) as student_fullname,
concat(g.firstname,' ',g.lastname) as teacher_fullname,
f.title as course_title,
e.session_count as scheduled_session_count,
d.sum_session_numbers as payed_session_count
 from 
students a,
students_courses b,
students_courses_registrations c,
(select student_course_registration_id,sum(session_numbers) as sum_session_numbers
from students_courses_registrations_payments
group by student_course_registration_id
) d,
(select student_course_registration_id,count(*) as session_count
from students_courses_schedules
group by student_course_registration_id) e,
courses f,
teachers g
where c.semester_id='".$semester_id."'
and a.id=b.student_id
and b.id=c.student_course_id
and c.id=d.student_course_registration_id
and c.id=e.student_course_registration_id
and e.session_count>d.sum_session_numbers
and b.course_id=f.id
and b.teacher_id=g.id
");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="6">لیست بدهکاران</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
		<td>تعداد جلسات برنامه ریزی شده</td>
		<td>تعداد جلسات پرداخت شده</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['student_fullname']; ?></td>
			<td><?php echo $row['course_title']; ?></td>
			<td><?php echo $row['teacher_fullname']; ?></td>
			<td><?php echo $row['scheduled_session_count']; ?></td>
			<td><?php echo $row['payed_session_count']; ?></td>
		</tr>
		<?php
	}
	?>
</table>