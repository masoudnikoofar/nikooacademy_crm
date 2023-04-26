<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php

//student_course_id

if ($_POST['step']=="2")
{
	$course_id=$db->mysql_real_escape_string($_POST['course_id']);
	$teacher_id=$db->mysql_real_escape_string($_POST['teacher_id']);
	
	$db->query("update students_courses set
	course_id='".$course_id."',
	teacher_id='".$teacher_id."'
	where id='".$student_course_id."'");
	alert("با موفقیت ویرایش شد");
	goback("index.php?pid=students&student_id=".$student_id."&func=courses");
}

$db->query("select * from students_courses where id='".$student_course_id."'");
$res=$db->result();
$row=$res[0];
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
						if ($row['course_id']==$row_tmp['id'])
							$selected="selected";
						else
							$selected="";
						?>
						<option value="<?php echo $row_tmp['id']; ?>" <?php echo $selected; ?>><?php echo $row_tmp['title']; ?></option>
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
						if ($row['teacher_id']==$row_tmp['id'])
							$selected="selected";
						else
							$selected="";
						?>
						<option value="<?php echo $row_tmp['id']; ?>" <?php echo $selected; ?>><?php echo $row_tmp['firstname']." ".$row_tmp['lastname']; ?></option>
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