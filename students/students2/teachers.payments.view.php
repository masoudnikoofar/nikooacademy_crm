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
order by 1
");
$res=$db->result();
foreach ($res as $row)
{
	/*
	$db->query("select 
	e.title as course_title,
	sum(d.session_numbers) as payed_session_numbers,
	sum(d.payment_amount) as payed_amount
	 from 
	 students_courses a,
	 students_courses_registrations b,
	 students_courses_registrations_payments d,
	 courses e
	where 
	a.teacher_id='".$teacher_id."'
	and a.id=b.student_course_id
	and b.id=d.student_course_registration_id
	and a.course_id=e.id
	and b.semester_id='".$semester_id."'
	group by e.title
	");      
	*/
	$db->query("select
		concat(d.firstname,' ',d.lastname) as student_fullname,
		e.title as course_title,
		c.total_count,
		c.count_status_0,
		c.count_status_1,
		c.count_status_2,
		c.count_status_3,
		truncate(f.session_tuition_fee,0) as session_tuition_fee,
		b.teacher_share as teacher_share,
		if (b.tuition_fee_off_percent>0,truncate(f.session_tuition_fee*100/(100-b.tuition_fee_off_percent)*b.teacher_share,0),truncate(f.session_tuition_fee*b.teacher_share/100,0)) as teacher_share_amount_per_session
		from
		students_courses a,
		students_courses_registrations b,
		
		(select student_course_registration_id,
		count(*) as total_count,
		sum(if(class_status=0,1,0)) as count_status_0,
		sum(if(class_status=1,1,0)) as count_status_1,
		sum(if(class_status=2,1,0)) as count_status_2,
		sum(if(class_status=3,1,0)) as count_status_3
		from students_courses_schedules where left(class_date,7)='".$row['class_date_month']."' group by student_course_registration_id) c,
		
		students d,
		courses e,
		
		(select student_course_registration_id,sum(payment_amount)/sum(session_numbers) as session_tuition_fee
		from students_courses_registrations_payments group by student_course_registration_id) f
		
		where
		a.id=b.student_course_id
		and b.id=c.student_course_registration_id
		and a.student_id=d.id
		and a.course_id=e.id
		and f.student_course_registration_id=b.id
		and a.teacher_id='".$teacher_id."'	
		and b.semester_id='".$semester_id."'
		order by 2,1
		");
	$res2=$db->result();
	?>
	<table class="tableslistr" width="100%" border="1">
		<tr class="tablesheader">
			<td colspan="10">
				<?php echo $row['class_date_month']; ?>
				<a href="index.php?pid=teachers&teacher_id=<?php echo $teacher_id; ?>&func=payments&func2=print&semester_id=<?php echo $semester_id;?>&class_date_month=<?php echo $row['class_date_month']; ?>"><img src="../images/buttons/print_small.png" border="0"></a>
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
				<td><?php echo $i++; ?></td>
				<td><?php echo $row2['student_fullname']; ?></td>
				<td><?php echo $row2['course_title']; ?></td>
				<td><?php echo $row2['count_status_1']; ?></td>
				<td><?php echo $row2['count_status_2']; ?></td>
				<td><?php echo $row2['count_status_3']; ?></td>
				<td><?php echo price_english($row2['session_tuition_fee']); ?></td>
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
}
?>
<!--
<script>
$("select#semester_id").change(function(){
    var semester_id = $("select#semester_id option:selected").attr('value');
    $.post("ajax/ajax.teachers.payments.view.php", {semester_id:semester_id}, function(data){
        $("select#month").html(data);
        });
    });
</script>
-->