<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<div style="height:0cm;">

</div>
<?php
$semester_id=$db->mysql_real_escape_string($_GET['semester_id']);
$teacher_id=$db->mysql_real_escape_string($_GET['teacher_id']);
$class_date_month=$db->mysql_real_escape_string($_GET['class_date_month']);

$db->query("select 
		concat(a.firstname,' ',a.lastname) as student_fullname,
		b.title as course_title,
		count(*) as total_count,
		sum(if(f.class_status=0,1,0)) as count_status_0,
		sum(if(f.class_status=1,1,0)) as count_status_1,
		sum(if(f.class_status=2,1,0)) as count_status_2,
		sum(if(f.class_status=3,1,0)) as count_status_3,
		truncate(e.tuition_fee_per_session,0) as tuition_fee_per_session,
		g.teacher_share as teacher_share,
		truncate(e.tuition_fee_per_session*g.teacher_share/100,0) as teacher_share_amount_per_session,
		tuition_fee_off_percent as tuition_fee_off_percent
		FROM
		students a,
		courses b,
		teachers c,
		students_courses d,
		students_courses_registrations e,
		students_courses_schedules f,
		students_courses_teachers_share g
		where 
		d.id=e.student_course_id
		and e.id=f.student_course_registration_id
		and g.student_course_id=d.id
		and a.id=d.student_id
		and b.id=d.course_id
		and c.id=d.teacher_id
		and g.start_date<=f.class_date
		and g.end_date>f.class_date
		and left(f.class_date,7)='".$class_date_month."'
		and c.id='".$teacher_id."'
		group by a.firstname,a.lastname,g.teacher_share
		order by 1,2");
		$res2=$db->result();
?>

<table class="tableslistr" width="100%" border="1">
	<tr>
		<td colspan="10"  style="direction:ltr;">
			<b>ماه :</b> <?php echo date_persian($class_date_month); ?><br/>
			<b>نام استاد :</b> 
			<?php
			$db->query("select * from teachers where id='".$teacher_id."'");
			$res3=$db->result();
			$row3=$res3[0];
			echo $row3['firstname']." ".$row3['lastname'];
			?><br/>
			<b>تاریخ :</b> <?php echo date_persian($today); ?><br/>
		</td>
	</tr>
	<tr class="tablesheader_print">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>دوره</td>
		<td>حاضر</td>
		<td>غایب</td>
		<td>کنسل</td>
		<td>شهریه هر جلسه</td>
		<td colspan="2">درصد و سهم استاد<br/>
		از شهریه هر جلسه</td>
		<td>جمع کل</td>
	</tr>
	<?php
	$i=1;
	$count_status_0_sum=0;
	$count_status_1_sum=0;
	$count_status_2_sum=0;
	$count_status_3_sum=0;
	
	$teacher_share_amount_total_sum=0;
	
	
	foreach ($res2 as $row2)
	{
		$teacher_share_amount_total = $row2['teacher_share_amount_per_session']*($row2['count_status_1']+$row2['count_status_2']);
		
		$count_status_0_sum+=$row2['count_status_0'];
		$count_status_1_sum+=$row2['count_status_1'];
		$count_status_2_sum+=$row2['count_status_2'];
		$count_status_3_sum+=$row2['count_status_3'];
		
		$teacher_share_amount_total_sum+=$teacher_share_amount_total;
		?>
		<tr>
			<td><?php echo number_persian($i++); ?></td>
			<td id="nowrap"><?php echo $row2['student_fullname']; ?></td>
			<td id="nowrap"><?php echo $row2['course_title']; ?></td>
			<td><?php echo number_persian($row2['count_status_1']); ?></td>
			<td><?php echo number_persian($row2['count_status_2']); ?></td>
			<td><?php echo number_persian($row2['count_status_3']); ?></td>
			<td>
				<?php echo price_persian($row2['tuition_fee_per_session']); ?>
				<?php
				if ($row2['tuition_fee_off_percent']>0)
				{
					?>
					(تخفیف: <?php echo number_persian($row2['tuition_fee_off_percent']); ?>%)
					<?php
				}
				?>
			</td>
			<td><?php echo number_persian($row2['teacher_share']); ?>%</td>
			<td><?php echo price_persian($row2['teacher_share_amount_per_session']); ?></td>
			<td><?php echo price_persian($teacher_share_amount_total); ?></td>
		</tr>
		<?php
	}
?>
	<tr class="tablessum">
		<td colspan="3">جمع</td>
		<td><?php echo number_persian($count_status_1_sum); ?></td>
		<td><?php echo number_persian($count_status_2_sum); ?></td>
		<td><?php echo number_persian($count_status_3_sum); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo price_persian($teacher_share_amount_total_sum); ?> ریال</td>
	</tr>
</table>
<?php
$db->query("select * from teachers_payments where 
teacher_id='".$teacher_id."' and
semester_id='".$semester_id."' and
class_date_month='".$class_date_month."'
");
$res=$db->result();
$row=$res[0];
?>
<table width="100%" class="tableslistr" border="1">
	<tr>
		<td><b>تاریخ پرداخت:</b><?php echo date_persian($row['payment_date']); ?></td>
	</tr>
	<tr>
		<td>
			<b>نوع پرداخت:</b>
			<?php 
			if ($row['payment_type']=="1") echo "نقدی";
			else if ($row['payment_type']=="2") echo "انتقال وجه کارت به کارت"; 
			?>
		</td>
	</tr>
	<?php
	if ($row['payment_type']=="2")
	{
	?>
		<tr>
			<td><b>شماره حواله:</b><?php echo number_persian($row['payment_info']); ?></td>
		</tr>
	<?php
	}
	?>
	<?php
	if ($row['comment']!="")
	{
	?>
		<tr>
			<td><b>توضیحات:</b><?php echo $row['comment']; ?></td>
		</tr>
	<?php
	}
	?>
</table>