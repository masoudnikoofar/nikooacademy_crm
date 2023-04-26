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

$timetable_start_date=$today;
$timetable_finish_date=$today;
$timetable_data_start_hour=10;
$timetable_data_finish_hour=22;
$timetable_data_hours=$timetable_data_finish_hour-$timetable_data_start_hour;


//$days_lable=array($today=>0);

$temp_date_f=new jDateTime(false,true,'Asia/Tehran');


$db->query("select * from rooms");
$res=$db->result();

$timetable_data_days_count=1;

$i=0;
foreach ($res as $row)
{
	$date=$today; 
	$room_id=$row['id'];
	$room_title=$row['title'];
	
	$dd=split("-",$date);
	$dd=$temp_date_f->mktime(0,0,0,$dd[1],$dd[2],$dd[0],true);//reuse of dd :D	
    $date_day_name=$temp_date_f->date("l",$dd);
	
    $days_lable[$date."_".$room_id]=array($i++,$date,$date_day_name,$room_title);
}


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