<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$student_course_registration_id=$db->mysql_real_escape_string($_GET['student_course_registration_id']);
if ($_POST['step']=="2")
{
    $class_count=$db->mysql_real_escape_string($_POST['class_count']);
    
    for ($i=0;$i<$class_count;$i++)
    {
        $class_date=$db->mysql_real_escape_string($_POST['class_date_'.$i]);
        $room_id=$db->mysql_real_escape_string($_POST['room_id_'.$i]);
        $class_start_time=$db->mysql_real_escape_string($_POST['class_start_time_'.$i]);
        $class_duration=$db->mysql_real_escape_string($_POST['class_duration_'.$i]);
        $comment=$db->mysql_real_escape_string($_POST['comment_'.$i]);
        
        $db->query("insert into students_courses_schedules set
        student_course_registration_id='".$student_course_registration_id."',
        class_date='".$class_date."',
        room_id='".$room_id."',
        class_start_time='".$class_start_time."',
        class_duration='".$class_duration."',
        comment='".$comment."'
        ");            
    }
                  
    alert("با موفقیت ثبت شد");
//    popup_close();
}
?>
<!-- view -->
<?php
$db->query("select * from students_courses_schedules where student_course_registration_id='".$student_course_registration_id."' order by class_date,id");
$res=$db->result();
?>
<table class="tableslistr" border="1">
    <tr class="tablesheader">
        <td rowspan="2">ردیف</td>
        <td rowspan="2">تاریخ</td>
        <td rowspan="2">اتاق</td>
        <td rowspan="2">ساعت شروع کلاس</td>
        <td rowspan="2">ساعت پایان کلاس</td>
        <td rowspan="2">توضیحات</td>
        <td rowspan="2">ویرایش</td>
        <td rowspan="2">حذف</td>
        <td colspan="4">وضعیت جلسه</td>
    </tr>
	<tr class="tablesheader">
		<td>نرمال</td>
		<td>حاضر</td>
		<td>غایب</td>
		<td>کنسل</td>
	</tr>
    <?php
    $i=1;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>    
            <td><?php echo $row['class_date']; ?></td>    
            <td>
				<?php
				$db->query("select * from rooms where id='".$row['room_id']."'");
				$res_tmp=$db->result();
				$row_tmp=$res_tmp[0];
				echo $row_tmp['title'];
				?>
			</td>    
            <td><?php echo $row['class_start_time']; ?></td>    
            <td><?php echo $row['class_duration']; ?></td>    
            <td><?php echo $row['comment']; ?></td>    
            <td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $student_course_registration_id; ?>&func2=registrations.schedule&student_course_schedule_id=<?php echo $row['id']; ?>&func3=edit"><img src="../images/buttons/edit2.png" border="0"></a></td>    
            <td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $student_course_registration_id; ?>&func2=registrations.schedule&student_course_schedule_id=<?php echo $row['id']; ?>&func3=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>    
			
			<td>
				<?php 
				if ($row['class_status']=="0")
				{
					?>
					<img src="../images/buttons/check_ok.png" border="0">
					<?php
				}
				else
				{
					?>
					<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $student_course_registration_id; ?>&func2=registrations.schedule&student_course_schedule_id=<?php echo $row['id']; ?>&func3=change.status&class_status=0"><img src="../images/buttons/check_nok.png" border="0"></a>	
					<?php
				}
				?>
			</td>
			<td>
				<?php 
				if ($row['class_status']=="1")
				{
					?>
					<img src="../images/buttons/check_ok.png" border="0">
					<?php
				}
				else
				{
					?>
					<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $student_course_registration_id; ?>&func2=registrations.schedule&student_course_schedule_id=<?php echo $row['id']; ?>&func3=change.status&class_status=1"><img src="../images/buttons/check_nok.png" border="0"></a>	
					<?php
				}
				?>
			</td>
			<td>
				<?php 
				if ($row['class_status']=="2")
				{
					?>
					<img src="../images/buttons/check_ok.png" border="0">
					<?php
				}
				else
				{
					?>
					<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $student_course_registration_id; ?>&func2=registrations.schedule&student_course_schedule_id=<?php echo $row['id']; ?>&func3=change.status&class_status=2"><img src="../images/buttons/check_nok.png" border="0"></a>	
					<?php
				}
				?>
				<td>
				<?php 
				if ($row['class_status']=="3")
				{
					?>
					<img src="../images/buttons/check_ok.png" border="0">
					<?php
				}
				else
				{
					?>
					<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $student_course_registration_id; ?>&func2=registrations.schedule&student_course_schedule_id=<?php echo $row['id']; ?>&func3=change.status&class_status=3"><img src="../images/buttons/check_nok.png" border="0"></a>	
					<?php
				}
				?>
			</td>
			</td>
        </tr>
        <?php
    }
    ?>
</table>
<hr/>
<!-- add or edit -->
<?php
$db->query("select * from students_courses_registrations where id='".$student_course_registration_id."'");
$res=$db->result();
$row=$res[0];

$semester_id=$row['semester_id'];

$db->query("select * from semesters where id='".$semester_id."'");

$res=$db->result();

$row=$res[0];

$semester_start_date=$row['start_date'];
$semester_finish_date=$row['finish_date'];

?>
<form method="post">
    <input type="hidden" name="step" value="1">
    اولین روز کلاس:<input type="text" name="class_first_date" value="<?php echo $semester_start_date; ?>" size="10"><?php calendar("class_first_date"); ?>
	اتاق: <select name="class_room_id">
		<option value="">--انتخاب کنید--</option>
		<?php
		$db->query("select * from rooms");
		$res_tmp=$db->result();
		foreach ($res_tmp as $row_tmp)
		{
			?>
			<option value="<?php echo $row_tmp['id']; ?>"><?php echo $row_tmp['title']; ?></option>
			<?php
		}
		?>
		</select>
    تعداد جلسات: <input type="text" name="class_count" value="12" size="2">
    ساعت شروع: <input type="text" name="class_start_time" value="00:00" size="5">
    ساعت پایان: <input type="text" name="class_duration" value="30" size="2"> دقیقه
    <button type="submit">اضافه</button>
</form>
<?php
if ($_POST['step']=="1")
{
    $class_first_date=$db->mysql_real_escape_string($_POST['class_first_date']);
    $class_room_id=$db->mysql_real_escape_string($_POST['class_room_id']);
    $class_start_time=$db->mysql_real_escape_string($_POST['class_start_time']);
    $class_duration=$db->mysql_real_escape_string($_POST['class_duration']);
    $class_count=$db->mysql_real_escape_string($_POST['class_count']);
    
    $dd=split("-",$class_first_date);
    
    $temp_date_f=new jDateTime(false,true,'Asia/Tehran');
    $dd=$temp_date_f->mktime(0,0,0,$dd[1],$dd[2],$dd[0],true);//reuse of dd :D
    ?>
    
    <form method="post">
        <input type="hidden" name="step" value="2">
        <input type="hidden" name="class_count" value="<?php echo $class_count; ?>">
        <table class="tableslistr" border="1">
            <tr class="tablesheader">
                <td>ردیف</td>
                <td>تاریخ</td>
                <td>اتاق</td>
                <td>ساعت شروع کلاس</td>
                <td>ساعت پایان کلاس</td>
                <td>توضیحات</td>
            </tr>
            <?php
            for ($i=0;$i<$class_count;$i++)
            {
                $date=$temp_date_f->date("Y-m-d",$dd);
                ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td>
                        <input type="text" name="class_date_<?php echo $i; ?>" value="<?php echo $date; ?>" size="10"><?php calendar("class_date_".$i); ?>
                    </td>
                    <td>
                        <select name="room_id_<?php echo $i; ?>">
							<?php
							$db->query("select * from rooms");
							$res_tmp=$db->result();
							foreach ($res_tmp as $row_tmp)
							{
								if ($row_tmp['id']==$class_room_id)
									$selected="selected";
								else
									$selected="";
								?>
								<option value=<?php echo $row_tmp['id']; ?>" <?php echo $selected; ?>><?php echo $row_tmp['title']; ?></option>
								<?php
							}
							?>
						</select>
                    </td>
					<td>                            
                        <input type="text" name="class_start_time_<?php echo $i; ?>" value="<?php echo $class_start_time; ?>" size="5">
                    </td>
                    <td>
                        <input type="text" name="class_duration_<?php echo $i; ?>" value="<?php echo $class_duration; ?>" size="2"> دقیقه
                    </td>
                    <td>
                        <input type="text" name="comment_<?php echo $i; ?>">
                    </td>
                </tr>
                <?php
                $dd=strtotime("+1 weeks", $dd);
            }
            ?>
        </table>
        <button type="submit">ثبت</button>
    </form>
    <?php
}
?>