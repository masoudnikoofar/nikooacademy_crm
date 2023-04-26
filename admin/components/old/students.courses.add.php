<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST['step']=="2")
{
	$course_id=$db->mysql_real_escape_string($_POST['course_id']);
	$teacher_id=$db->mysql_real_escape_string($_POST['teacher_id']);
	
	$db->query("insert into students_courses set
	student_id='".$student_id."',
	course_id='".$course_id."',
	teacher_id='".$teacher_id."',
	reg_date='".$today."'
	");
	
	$db->query("select id from students_courses order by id desc limit 0,1");
	$res=$db->result();
	$row=$res[0];
	$student_course_id=$row['id'];
	
	$db->query("insert into students_courses_teachers_share set
	student_course_id='".$student_course_id."',
	start_date='0000-00-00',
	end_date='9999-99-99',
	teacher_share=50
	");
	
	alert("با موفقیت ثبت شد");
	goback("index.php?pid=students&student_id=".$student_id."&func=courses");
}
?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<table class="tables">
		<tr>
			<td>نام دوره</td>
			<td>
				<select name="course_id">
					<option value="">--انتخاب کنید--</option>
					<?php
					$db->query("select * from courses");
					$res_tmp=$db->result();
					foreach ($res_tmp as $row_tmp)
					{
						?>
						<option value="<?php echo $row_tmp['id']; ?>"><?php echo $row_tmp['title']; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>نام استاد</td>
			<td>
				<select name="teacher_id">
					<option value="">--انتخاب کنید--</option>
					<?php
					$db->query("select * from teachers");
					$res_tmp=$db->result();
					foreach ($res_tmp as $row_tmp)
					{
						?>
						<option value="<?php echo $row_tmp['id']; ?>"><?php echo $row_tmp['firstname']." ".$row_tmp['lastname']; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>