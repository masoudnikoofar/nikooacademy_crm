<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
	
	$title=$_POST['title'];
	$category_id=$_POST['category_id'];
	$teacher_id=$_POST['teacher_id'];
	$tuition_fee=$_POST['tuition_fee'];
	$tuition_fee_session=$_POST['tuition_fee_session'];
	$discount_rate=$_POST['discount_rate'];
	$start_date=$_POST['start_date'];
	$finish_date=$_POST['finish_date'];
	$course_duration=$_POST['course_duration'];
	$session_no=$_POST['session_no'];
	
    $db->query("update courses set
		title='".$title."',
		tuition_fee='".$tuition_fee."',
		tuition_fee_session='".$tuition_fee_session."',
		discount_rate='".$discount_rate."',
		start_date='".$start_date."',
		finish_date='".$finish_date."',
		course_duration='".$course_duration."',
		session_no='".$session_no."',
		category_id='".$category_id."',
		teacher_id='".$teacher_id."'
		where id='$course_id'"
	);
    alert("با موفقیت ویرایش شد");
    goback("index.php?pid=courses");
}
$db->query("select * from courses where id='$course_id'");
$res=$db->result();
$row=$res[0];
$title=$row['title'];
$category_id=$row['category_id'];
$tuition_fee=$row['tuition_fee'];
$tuition_fee_session=$row['tuition_fee_session'];
$discount_rate=$row['discount_rate'];
$start_date=$row['start_date'];
$finish_date=$row['finish_date'];
$course_duration=$row['course_duration'];
$session_no=$row['session_no'];
$teacher_id=$row['teacher_id'];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables" >
<tr><td colspan="2" class="tablesheader">اضافه کردن درس جدید</td></tr>
<tr>
    <td align="left"><b>گروه:</b></td>
    <td>
        <select name="category_id" id="category_id">
			<option value="">--انتخاب کنید--</option>
			<?php
			$db->query("select * from courses_categories where parent_id=0 order by title");
			$res=$db->result();
			foreach ($res as $row)
			{
				?>
				<option value="">------------------</option>
				<?php
				$db->query("select * from courses_categories where parent_id='".$row['id']."' order by title");
				$res2=$db->result();
				foreach ($res2 as $row2)
				{
					?>
					<option value="<?php echo $row2['id']; ?>" <?php if ($category_id=$row2['id']) echo "selected"; ?>><?php echo $row['title']; ?> --> <?php echo $row2['title']; ?></option>
					<?php
				}
			}
			?>
		</select>
    </td>
</tr>
<tr>
    <td align="left"><b>استاد:</b></td>
    <td>
        <select name="teacher_id">
			<option value="">--انتخاب کنید--</option>
			<?php
			$db->query("select * from teachers order by firstname,lastname");
			$res=$db->result();
			foreach ($res as $row)
			{
				?>
				<option value="<?php echo $row['id']; ?>" <?php if ($teacher_id==$row['id']) echo "selected"; ?>><?php echo $row['firstname']." ".$row['lastname']; ?></option>
				<?php
			}
			?>
		</select>
    </td>
</tr>
<tr>
    <td align="left"><b>نام درس:</b></td>
    <td>
        <input type="text" name="title" id="title" value="<?php echo $title; ?>"> پیش فرض ساخته می شود
    </td>
</tr>
<tr>
    <td align="left"><b>شهریه:</b></td>
    <td>
        <input type="text" name="tuition_fee" id="tuition_fee" value="<?php echo $tuition_fee; ?>">
    </td>
</tr>
<tr>
    <td align="left"><b>شهریه هر جلسه:</b></td>
    <td>
        <input type="text" name="tuition_fee_session" id="tuition_fee_session" value="<?php echo $tuition_fee_session; ?>">
    </td>
</tr>
<tr>
    <td align="left"><b>درصد تخفیف:</b></td>
    <td>
        <input type="text" name="discount_rate" id="discount_rate" value="<?php echo $discount_rate; ?>">%
    </td>
</tr>
<tr>
    <td align="left"><b>تاریخ شروع:</b></td>
    <td><input type="text" name="start_date" value="<?php echo $start_date; ?>"><?php calendar("start_date"); ?></td>
</tr>
<tr>
    <td align="left"><b>تاریخ پایان:</b></td>
    <td><input type="text" name="finish_date" value="<?php echo $finish_date; ?>"><?php calendar("finish_date"); ?></td>
</tr>
<tr>
    <td align="left"><b>طول دوره (ساعت):</b></td>
    <td><input type="text" name="course_duration" id="course_duration" value="<?php echo $course_duration; ?>"></td>
</tr>
<tr>
    <td align="left"><b>تعداد جلسات:</b></td>
    <td><input type="text" name="session_no" id="session_no" value="<?php echo $session_no; ?>"></td>
</tr>


<tr><td colspan="2" align="center"><button type="submit">اضافه</button></td></tr>
</table>
</form>
<script>
var categories = {
	<?php
	$db->query("select * from courses_categories order by id");
	$res = $db->result();
	foreach ($res as $row)
	{
		?>
		"<?php echo $row['id']; ?>":[
		"<?php echo $row['id']; ?>",
		"<?php echo $row['tuition_fee']; ?>",
		"<?php echo $row['tuition_fee_session']; ?>",
		"<?php echo $row['course_duration']; ?>",
		"<?php echo $row['session_no']; ?>"
		],
		<?php
	}
	?>
}

$(document).ready(function(){
	//this if you want that changing province this alert country value
    $("#category_id").on("change",function(e){
  	    
          var category_id =$(this).val();
          if(!category_id) return;
          $("#tuition_fee").val(categories[category_id][1]);
          $("#tuition_fee_session").val(categories[category_id][2]);
          $("#course_duration").val(categories[category_id][3]);
          $("#session_no").val(categories[category_id][4]);
    });
  
});
</script>