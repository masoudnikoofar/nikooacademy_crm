<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['teacher_share_id']))
{
	$teacher_share_id=$_GET['teacher_share_id'];
}

if ($_POST[step]=="2")
{
	if ($teacher_share_id=="")
	{
		$db->query("insert into students_courses_teachers_share set 
		student_course_id='".$student_course_id."',
		start_date='".$_POST['start_date']."',
		end_date='".$_POST['end_date']."',
		teacher_share='".$_POST['teacher_share']."'		
		");
		alert("با موفقیت اضافه شد");
	}
	else
	{
		$db->query("update students_courses_teachers_share set 
		start_date='".$_POST['start_date']."',
		end_date='".$_POST['end_date']."',
		teacher_share='".$_POST['teacher_share']."'		
		where id='".$teacher_share_id."'
		");
		alert("با موفقیت ویرایش شد");
	}
}
if ($teacher_share_id<>"")
{
	$db->query("select * from students_courses_teachers_share where id='".$teacher_share_id."'");
	$res=$db->result();
	$row=$res[0];
	$start_date=$row['start_date'];
	$end_date=$row['end_date'];
	$teacher_share=$row['teacher_share'];
}
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="60%" class="tables">
<tr><td align="left"><b>تاریخ شروع:</b></td><td><input type="text" name="start_date" value="<?php echo $start_date; ?>"><?php calendar("start_date"); ?></td></tr>
<tr><td align="left"><b>تاریخ پایان:</b></td><td><input type="text" name="end_date" value="<?php echo $end_date; ?>"><?php calendar("end_date"); ?></td></tr>
<tr><td align="left"><b>درصد سهم:</b></td><td><input type="text" name="teacher_share" value="<?php echo $teacher_share; ?>"> ریال<td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>

<table class="tableslistr" border="1">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>تاریخ شروع</td>
		<td>تاریخ پایان</td>
		<td>درصد سهم</td>
		<td>ویرایش</td>
	</tr>
	<?php
	$db->query("select * from students_courses_teachers_share where student_course_id='".$student_course_id."'");
	$res=$db->result();
	$i=1;
	foreach($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['start_date']; ?></td>
			<td><?php echo $row['end_date']; ?></td>
			<td><?php echo $row['teacher_share']; ?></td>
			<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $student_course_id; ?>&func2=teachers_share&teacher_share_id=<?php echo $row['id']; ?>"><img src="../images/buttons/edit2.png" border="0"></a></td>    
		</tr>
		<?php
	}
	?>
</table>