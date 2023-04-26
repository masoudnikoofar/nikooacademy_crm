<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$student_course_registration_id=$db->mysql_real_escape_string($_GET['student_course_registration_id']);

if ($_POST['step']=="2")
{
	$db->query("update students_courses_registrations set
		semester_id='".$_POST['semester_id']."',
		date='".$_POST['date']."',
		tuition_fee='".$_POST['tuition_fee']."',
		tuition_fee_per_session='".$_POST['tuition_fee_per_session']."',
		tuition_fee_off_percent='".$_POST['tuition_fee_off_percent']."',
		teacher_share='".$_POST['teacher_share']."',
		comment='".$_POST['comment']."'
		where id='".$student_course_registration_id."'
		");
	alert("با موفقیت ثبت شد");
	popup_close();
}


$db->query("select * from students_courses_registrations where id='".$student_course_registration_id."'");
$res=$db->result();
$row=$res[0];
$date=$row['date'];
$tuition_fee=$row['tuition_fee'];
$tuition_fee_per_session=$row['tuition_fee_per_session'];
$tuition_fee_off_percent=$row['tuition_fee_off_percent'];
$semester_id=$row['semester_id'];
$teacher_share=$row['teacher_share'];
$comment=$row['comment'];

?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="100%">
		<tr>
			<td align="left"><b>تاریخ:</b></td>
			<td><input type="text" name="date" dir="ltr" value="<?php echo $date; ?>"><?php calendar("date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>شهریه:</b></td>
			<td><input type="text" name="tuition_fee" value="<?php echo $tuition_fee; ?>"></td>
		</tr>
		<tr>
			<td align="left"><b>شهریه هر جلسه:</b></td>
			<td><input type="text" name="tuition_fee_per_session" value="<?php echo $tuition_fee_per_session; ?>"></td>
		</tr>
		<tr>
			<td align="left"><b>درصد تخفیف:</b></td>
			<td><input type="text" name="tuition_fee_off_percent" value="<?php echo $tuition_fee_off_percent; ?>" size="2">%</td>
		</tr>
		<tr>
			<td align="left"><b>ترم:</b></td>
			<td>
				<select name="semester_id">
					<option value="">--انتخاب کنید--</option>
					<?php
					$db->query("select * from semesters order by id desc");
					$res=$db->result();
					foreach ($res as $row)
					{
						if ($row['id']==$semester_id)
							$selected="selected";
						else
							$selected="";
						?>
							<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['title']; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left"><b>سهم استاد:</b></td>
			<td><input type="text" name="teacher_share" value="<?php echo $teacher_share; ?>" size="2">%</td>
		</tr>
		<tr>
			<td align="left"><b>توضیحات:</b></td>
			<td><textarea name="comment"><?php echo $comment; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>