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
a.id as student_id,
concat(a.firstname,' ',a.lastname) as student_fullname,
concat(g.firstname,' ',g.lastname) as teacher_fullname,
f.title as course_title,
c.tuition_fee_off_percent as tuition_fee_off_percent
 from 
students a,
students_courses b,
students_courses_registrations c,
courses f,
teachers g
where c.semester_id='".$semester_id."'
and a.id=b.student_id
and b.id=c.student_course_id
and b.course_id=f.id
and b.teacher_id=g.id
and c.tuition_fee_off_percent<>0
order by 2 desc
");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="7">لیست دانشجویانی که تخفیف دارند</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
		<td>درصد تخفیف</td>
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
			<td><?php echo $row['tuition_fee_off_percent']; ?> %</td>
		</tr>
		<?php
	}
	?>
</table>