<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
/*
tt-event btn-success
tt-event btn-primary
tt-event btn-warning
tt-event btn-danger
tt-event btn-info
*/
?>
<div id="test"></div>
<?php

$x="";

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
if (isset($_POST['teacher_id']) and $_POST['teacher_id']<>"")
{
	$teacher_id=$db->mysql_real_escape_string($_POST['teacher_id']);
	$x.=" and teacher_id='".$teacher_id."'";
}
else
{
	$teacher_id="";
}
?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<select name="semester_id">
		<?php
		$db->query("select * from semesters");
		$res=$db->result();
		foreach ($res as $row)
		{
			$selected="";
			if ($row['id']==$semester_id) $selected="selected";
			?>
			<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['title']; ?></option>
			<?php
		}
		?>
	</select>
	<select name="teacher_id">
		<option value="">--انتخاب کنید--</option>
		<?php
		$db->query("select * from teachers");
		$res=$db->result();
		foreach ($res as $row)
		{
			$selected="";
			if ($row['id']==$teacher_id) $selected="selected";
			?>
			<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['firstname']." ".$row['lastname']; ?></option>
			<?php
		}
		?>
	</select>
	<button type="submit">نمایش</button>
</form>
<?php
if ($_POST['step']=="2")
{
	$db->query("select * from semesters where id='".$semester_id."'");
	$res=$db->result();
	$row=$res[0];

	$timetable_start_date=$row['start_date'];
	$timetable_finish_date=$row['finish_date'];
	$timetable_data_start_hour=10;
	$timetable_data_finish_hour=22;
	$timetable_data_hours=$timetable_data_finish_hour-$timetable_data_start_hour;


	//$days_lable=array($today=>0);

	$temp_date_f=new jDateTime(false,true,'Asia/Tehran');


	$db->query("select distinct a.class_date as class_date,a.room_id as room_id,b.title as room_title from students_courses_schedules a,rooms b
	where a.room_id=b.id and a.class_date between '".$timetable_start_date."' and '".$timetable_finish_date."' order by a.class_date");
	$res=$db->result();

	$timetable_data_days_count=count($res);

	$i=0;
	foreach ($res as $row)
	{
		$date=$row['class_date']; 
		$room_id=$row['room_id'];
		$room_title=$row['room_title'];
		
		$dd=split("-",$date);
		$dd=$temp_date_f->mktime(0,0,0,$dd[1],$dd[2],$dd[0],true);//reuse of dd :D	
		$temp_date_f->date("Y-m-d",$dd);
		$date_day_name=$temp_date_f->date("l",$dd);
		
		$days_lable[$date."_".$room_id]=array($i++,$date,$date_day_name,$room_title);
	}

	/*
	$db->query("select 
	a.*,
	CONCAT_WS(' ',d.firstname,d.lastname) as student_fullname,
	CONCAT_WS(' ',e.firstname,e.lastname) as teacher_fullname,
	f.title as course_title

	 from 
	students_courses_schedules a,
	students_courses_registrations b,
	students_courses c,
	students d,
	teachers e,
	courses f
	where a.class_date between '".$timetable_start_date."' and '".$timetable_finish_date."' 
	and b.id=a.student_course_registration_id
	and b.student_course_id=c.id
	and c.student_id=d.id
	and c.teacher_id=e.id
	and c.course_id=f.id
	$x
	order by a.class_date");
	*/


	$db->query("select * from students_courses_schedules_view
	where class_date between '".$timetable_start_date."' and '".$timetable_finish_date."'
	$x
	");

	$res=$db->result();
	?>


	<div dir="ltr" align="left">
		<div style="height: 345px;" class="timetable" data-days="<?php echo $timetable_data_days_count; ?>" data-hours="<?php echo $timetable_data_hours; ?>">
		<ul style="left:38px; top: 29px;" class="tt-events">
		   <?php
		   foreach ($res as $row)
			{
				$id=$row['id'];
				$class_date=$row['class_date'];
				$class_start_time=split(":",$row['class_start_time']);
				$class_start_time=$class_start_time[0]+$class_start_time[1]/60-$timetable_data_start_hour;
				$class_duration=$row['class_duration']/60;
				$class_room_id=$row['room_id'];
				$class_status=$row['class_status'];
				
				switch ($class_status) {
					case 0:
						$class_class="tt-event btn-info";
						break;
					case 1:
						$class_class="tt-event btn-success";
						break;
					case 2:
						$class_class="tt-event btn-warning";
						break;
					case 3:
						$class_class="tt-event btn-danger";
						break;
				}

	/*


	tt-event btn-success
	tt-event btn-primary
	tt-event btn-warning
	tt-event btn-danger
	tt-event btn-info
				
				
				0=normal
	1=hazer
	2=ghayeb
	3=cancle'

	*/
				
				
				?>
				<li style="-moz-user-select: none; top: 0px; left: 0px; width: 202.5px;" unselectable="on" rel="tooltip" class="<?php echo $class_class;?>" data-id="<?php echo $row['id']; ?>" data-day="<?php echo $days_lable[$class_date."_".$class_room_id][0]; ?>" data-start="<?php echo $class_start_time; ?>" data-duration="<?php echo $class_duration; ?>">
				<?php
					echo $row['student_fullname']."<br/>".$row['teacher_fullname']."<br/>".$row['course_title']."<br/>"."شروع:".$row['class_start_time'];
				?>
				</li>
				<?php
			}
			?>
		</ul>                                                                                                                                                                                                                                                                                                                                                                       
		<div style="padding-left:75px;" class="tt-times">
			<?php
			for ($i=$timetable_data_start_hour;$i<$timetable_data_finish_hour-1;++$i)
			{
			?>
				<div style="width: 130px; height: 334px; margin-bottom: -334px;" class="tt-time" data-time="<?php echo $i; ?>">
					<?php echo $i; ?><span class="hidden-phone">:00</span>
				</div>
			<?php
			}
			?>
			<div style="width: 132px;" class="tt-time" data-time="<?php echo $i; ?>">
				<?php echo $i; ?><span class="hidden-phone">:00</span>
			</div>
		</div>
		<div style="width: 38px; top: 29px;" class="tt-days">
			<?php              
			$i=0;
			foreach($days_lable as $day_lable)
			{
			?>                
			<div style=" width: 1157px; margin-right: -1129px;" class="tt-day" data-day="<?php echo $i++; ?>">
				<?php
				echo $day_lable[1]."<br/>".$day_lable[2]."<br/>".$day_lable[3]; 
				?>
			</div>
			<?php
			}
			?>            
		</div>
	</div>
<?php
}
?>