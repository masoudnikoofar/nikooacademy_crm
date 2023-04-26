<?php
if ($_POST['step']=="3") //3 cause of conflict with list -- masoud
{
	$class_date=$db->mysql_real_escape_string($_POST['class_date']);
	$room_id=$db->mysql_real_escape_string($_POST['room_id']);
	$class_start_time=$db->mysql_real_escape_string($_POST['class_start_time']);
	$class_duration=$db->mysql_real_escape_string($_POST['class_duration']);
	$comment=$db->mysql_real_escape_string($_POST['comment']);
	
	$db->query("update students_courses_schedules set
	class_date='".$class_date."',
	room_id='".$room_id."',
	class_start_time='".$class_start_time."',
	class_duration='".$class_duration."',
	comment='".$comment."'
	where id='".$student_course_schedule_id."'
	");            
	alert("با موفقیت ویرایش شد");
	goback("index.php?pid=students&student_id=".$student_id."&func=courses&student_course_registration_id=".$student_course_registration_id."&func2=registrations.schedule");
}
$db->query("select * from students_courses_schedules where id='".$student_course_schedule_id."'");
$res=$db->result();
$row=$res[0];

$room_id=$row['room_id'];
$class_date=$row['class_date'];
$class_start_time=$row['class_start_time'];
$class_duration=$row['class_duration'];
$comment=$row['comment'];

?>
<form method="post">
	<input type="hidden" name="step" value="3">
	<table class="tables">
		<tr>
			<td align="left"><b>تاریخ</b></td>
			<td><input type="text" name="class_date" value="<?php echo $class_date; ?>"><?php calendar("class_date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>اتاق</b></td>
			<td>
				<select name="room_id">
					<?php
					$db->query("select * from rooms");
					$res_tmp=$db->result();
					foreach ($res_tmp as $row_tmp)
					{
						if ($row_tmp['id']==$room_id)
							$selected="selected";
						else
							$selected="";
						?>
						<option value=<?php echo $row_tmp['id']; ?>" <?php echo $selected; ?>><?php echo $row_tmp['title']; ?></option>
						<?php
					}
					?>
			</td>
		</tr>
		<tr>
			<td align="left"><b>ساعت شروع کلاس</b></td>
			<td><input type="text" name="class_start_time" value="<?php echo $class_start_time; ?>"></td>
		</tr>
		<tr>
			<td align="left"><b>مدت کلاس</b></td>
			<td><input type="text" name="class_duration" value="<?php echo $class_duration; ?>"> دقیقه</td>
		</tr>
		<tr>
			<td align="left"><b>توضیحات</b></td>
			<td><textarea name="comment"><?php echo $comment; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">ویرایش</button></td>
		</tr>
	</table>
</form>