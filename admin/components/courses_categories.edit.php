<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
	$title=$_POST['title'];
	$parent_id=$_POST['parent_id'];
	
	$title=$db->mysql_real_escape_string($_POST['title']);
	$parent_id=$db->mysql_real_escape_string($_POST['parent_id']);
	$tuition_fee=$db->mysql_real_escape_string($_POST['tuition_fee']);
	$tuition_fee_session=$db->mysql_real_escape_string($_POST['tuition_fee_session']);
	$course_duration=$db->mysql_real_escape_string($_POST['course_duration']);
	$teacher_tuition_share=$db->mysql_real_escape_string($_POST['teacher_tuition_share']);
	$course_owner_tuition_share=$db->mysql_real_escape_string($_POST['course_owner_tuition_share']);
	$certificate_tuition_share=$db->mysql_real_escape_string($_POST['certificate_tuition_share']);
	$session_no=$db->mysql_real_escape_string($_POST['session_no']);
	$moodle_shortname_pattern=$db->mysql_real_escape_string($_POST['moodle_shortname_pattern']);
	
    $db->query("update courses_categories set
		title='".$title."',
		parent_id='".$parent_id."',
		tuition_fee='".$tuition_fee."',
		tuition_fee_session='".$tuition_fee_session."',
		course_duration='".$course_duration."',
		teacher_tuition_share='".$teacher_tuition_share."',
		course_owner_tuition_share='".$course_owner_tuition_share."',
		certificate_tuition_share='".$certificate_tuition_share."',
		session_no='".$session_no."',
		moodle_shortname_pattern='".$moodle_shortname_pattern."'
		where id='".$course_category_id."'
	");	
    alert("با موفقیت اضافه شد");
}
$db->query("select * from courses_categories where id='".$course_category_id."'");
$res_tmp = $db->result();
$row_tmp = $res_tmp[0];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables" >
	<tr><td colspan="2" class="tablesheader">ویرایش گروه</td></tr>
	<tr>
		<td align="left"><b>گروه پدر:</b></td>
		<td>
			<select name="parent_id">
				<option value="">--انتخاب کنید--</option>
				<?php
				$db->query("select * from courses_categories where parent_id=0 order by title");
				$res=$db->result();
				foreach ($res as $row)
				{
					?>
					<option value="<?php echo $row['id']; ?>" <?php if ($row['id']==$row_tmp['parent_id']) echo "selected"; ?>><?php echo $row['title']; ?></option>
					<?php
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="left"><b>نام گروه:</b></td>
		<td>
			<input type="text" name="title" value="<?php echo $row_tmp['title']; ?>">
		</td>
	</tr>
	<tr>
		<td align="left"><b>شهریه:</b></td>
		<td>
			<input type="text" name="tuition_fee" id="tuition_fee" value="<?php echo $row_tmp['tuition_fee']; ?>">
		</td>
	</tr>
	<!--
	<tr>
		<td align="left"><b>شهریه هر جلسه:</b></td>
		<td>
			<input type="text" name="tuition_fee_session" id="tuition_fee_session">
		</td>
	</tr>
	-->
	<tr>
		<td align="left"><b>درصد سهم استاد:</b></td>
		<td>
			<input type="text" name="teacher_tuition_share" id="teacher_tuition_share" value="<?php echo $row_tmp['teacher_tuition_share']; ?>">%
		</td>
	</tr>
	<tr>
		<td align="left"><b>درصد سهم صاحب دوره:</b></td>
		<td>
			<input type="text" name="course_owner_tuition_share" id="course_owner_tuition_share" value="<?php echo $row_tmp['course_owner_tuition_share']; ?>">%
		</td>
	</tr>
	<tr>
		<td align="left"><b>درصد سهم صادرکننده مدرک:</b></td>
		<td>
			<input type="text" name="certificate_tuition_share" id="certificate_tuition_share" value="<?php echo $row_tmp['certificate_tuition_share']; ?>">%
		</td>
	</tr>
	<tr>
		<td align="left"><b>طول دوره (ساعت):</b></td>
		<td><input type="text" name="course_duration" id="course_duration" value="<?php echo $row_tmp['course_duration']; ?>"></td>
	</tr>
	<tr>
		<td align="left"><b>تعداد جلسات:</b></td>
		<td><input type="text" name="session_no" id="session_no" value="<?php echo $row_tmp['session_no']; ?>"></td>
	</tr>
	<tr>
		<td align="left"><b>Moodle Short Name:</b></td>
		<td><input type="text" name="moodle_shortname_pattern" id="moodle_shortname_pattern" value="<?php echo $row_tmp['moodle_shortname_pattern']; ?>"></td>
	</tr>
	<tr><td colspan="2" align="center"><button type="submit">اضافه</button></td></tr>
</table>
</form>