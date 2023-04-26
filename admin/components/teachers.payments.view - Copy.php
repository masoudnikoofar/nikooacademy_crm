<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
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
?>
<form method="post">
	<select name="semester_id" id="semester_id">
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
	
	<button type="submit">نمایش</button>
</form>

<?php
$db->query("select distinct left(c.class_date,7) as class_date_month from
students_courses a,
students_courses_registrations b,
students_courses_schedules c
where a.id=b.student_course_id
and b.id=student_course_registration_id
and a.teacher_id='".$teacher_id."'
and b.semester_id='".$semester_id."'
order by 1 desc
");
$res=$db->result();
foreach ($res as $row)
{
	$class_date_month=$row['class_date_month'];
	$sql="select
		concat(d.firstname,' ',d.lastname) as student_fullname,
		e.title as course_title,
		c.total_count,
		c.count_status_0,
		c.count_status_1,
		c.count_status_2,
		c.count_status_3,
		truncate(b.tuition_fee_per_session,0) as tuition_fee_per_session,
		f.teacher_share as teacher_share,
		truncate(b.tuition_fee_per_session*f.teacher_share/100,0) as teacher_share_amount_per_session,
		tuition_fee_off_percent as tuition_fee_off_percent
		from
		students_courses a,
		students_courses_registrations b,
		
		(select student_course_registration_id,
		count(*) as total_count,
		sum(if(class_status=0,1,0)) as count_status_0,
		sum(if(class_status=1,1,0)) as count_status_1,
		sum(if(class_status=2,1,0)) as count_status_2,
		sum(if(class_status=3,1,0)) as count_status_3
		from students_courses_schedules where left(class_date,7)='".$class_date_month."' group by student_course_registration_id) c,
		
		students d,
		courses e,
		students_courses_teachers_share f
		
		where
		a.id=b.student_course_id
		and b.id=c.student_course_registration_id
		and a.student_id=d.id
		and a.course_id=e.id
		and a.teacher_id='".$teacher_id."'	
		and b.semester_id='".$semester_id."'
		and f.student_course_id=a.id
		and (
			left(f.start_date,7)<='".$class_date_month."' and left(end_date,7)>='".$class_date_month."'
		)
		and (
			left(f.start_date,7)<='".$class_date_month."' and left(end_date,7)>='".$class_date_month."'
		)
		order by 2,1
		";
		//echo $sql;
		$db->query($sql);
	$res2=$db->result();
	?>
	<table class="tableslistr" width="100%" border="1">
		<tr class="tablesheader">
			<td colspan="10">
				<?php echo $class_date_month; ?>
				<a href="index.php?pid=teachers&teacher_id=<?php echo $teacher_id; ?>&func=payments&func2=print&semester_id=<?php echo $semester_id;?>&class_date_month=<?php echo $class_date_month; ?>"><img src="../images/buttons/print_small.png" border="0"></a>
				<a href="index.php?pid=teachers&teacher_id=<?php echo $teacher_id; ?>&func=payments&func2=extra_info&semester_id=<?php echo $semester_id;?>&class_date_month=<?php echo $class_date_month; ?>"><img src="../images/buttons/add2.png" border="0"></a>
			</td>
		</tr>
		<tr class="tablesheader">
			<td>ردیف</td>
			<td>نام دانشجو</td>
			<td>دوره</td>
			<td>حاضر</td>
			<td>غایب</td>
			<td>کنسل</td>
			<td>شهریه هر جلسه</td>
			<td colspan="2">
				درصد و سهم استاد<br/>
				از شهریه هر جلسه
			</td>
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
				<td><?php echo $i++; ?></td>
				<td><?php echo $row2['student_fullname']; ?></td>
				<td><?php echo $row2['course_title']; ?></td>
				<td><?php echo $row2['count_status_1']; ?></td>
				<td><?php echo $row2['count_status_2']; ?></td>
				<td><?php echo $row2['count_status_3']; ?></td>
				<td>
					<?php echo price_english($row2['tuition_fee_per_session']); ?>
					<?php
					if ($row2['tuition_fee_off_percent']>0)
					{
						?>
						(تخفیف: <?php echo $row2['tuition_fee_off_percent']; ?>%)
						<?php
					}
					?>
				</td>
				<td><?php echo $row2['teacher_share']; ?>%</td>
				<td><?php echo price_english($row2['teacher_share_amount_per_session']); ?></td>
				<td><?php echo price_english($teacher_share_amount_total); ?></td>
			</tr>
			<?php
		}
	?>
		<tr class="tablessum">
			<td colspan="3">جمع</td>
			<td><?php echo $count_status_1_sum; ?></td>
			<td><?php echo $count_status_2_sum; ?></td>
			<td><?php echo $count_status_3_sum; ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo price_english($teacher_share_amount_total_sum); ?></td>
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
			<td><b>تاریخ پرداخت:</b><?php echo $row['payment_date']; ?></td>
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
				<td><b>شماره حواله:</b><?php echo $row['payment_info']; ?></td>
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
<?php
}
?>
<?php

?>