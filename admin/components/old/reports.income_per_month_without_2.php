<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>

<?php
if (isset($_POST['min_date']) and $_POST['min_date']>"")
{	
	$min_date=$db->mysql_real_escape_string($_POST['min_date']);
}
else
{
	$temp_date_f=new jDateTime(false,true,'Asia/Tehran');
			
	$dd=split("-",$today);

	$dd=$temp_date_f->mktime(0,0,0,$dd[1],$dd[2],$dd[0],true);//reuse of dd :D
	$dd=strtotime("-1 years", $dd); 	
	$date=$temp_date_f->date("Y-m-d",$dd);
	$min_date=$date;
}
if (isset($_POST['max_date']) and $_POST['max_date']>"")
{	
	$max_date=$db->mysql_real_escape_string($_POST['max_date']);
}
else
{
	$max_date=$today;
}

$db->query("
select 
left(b.date,7) as month,sum(b.payment_amount) as sum_payment_amount
from students_courses_registrations a,
students_courses_registrations_payments b
where a.id=b.student_course_registration_id
and b.date between '".$min_date."' and '".$max_date."'
group by left(b.date,7)
order by left(b.date,7)
");
$res=$db->result();
foreach ($res as $row)
{
	$arr1[$row['month']]=$row['sum_payment_amount'];
}

$db->query("
select
left(c.class_date,7) as month,
sum((if(c.class_status=1,1,0)+if(c.class_status=2,1,0))*truncate(b.tuition_fee_per_session*f.teacher_share/100,0)) as teachers_salary
from
students_courses a,
students_courses_registrations b,
students_courses_schedules c,
students_courses_teachers_share f		
where
a.id=b.student_course_id
and b.id=c.student_course_registration_id
and f.student_course_id=a.id
and c.class_date between '".$min_date."' and '".$max_date."'
and a.teacher_id not in (1)
group by left(c.class_date,7)
order by left(c.class_date,7)
");
$res=$db->result();
foreach ($res as $row)
{
	$arr2[$row['month']]=$row['teachers_salary'];
}


$db->query("select left(x.date,7) month,
sum(((time_to_sec(exit_time)-time_to_sec(enter_time))/60/60)*y.base_wage) as sum_wage
from
people_rollcall x left join people_base_wage y
on x.date between y.start_date and y.end_date and x.person_id=y.person_id
where x.date between '".$min_date."' and '".$max_date."'
group by left(x.date,7)
order by left(x.date,7)");
$res=$db->result();
foreach ($res as $row)
{
	$arr3[$row['month']]=$row['sum_wage'];
}


$db->query("select left(x.date,7) as month,
sum(amount) as amount
from
other_costs x
where x.date between '".$min_date."' and '".$max_date."'
group by left(x.date,7)
order by left(x.date,7)");
$res=$db->result();
foreach ($res as $row)
{
	$arr4[$row['month']]=$row['amount'];
}


$month_index_arr="";
$temp_date_f=new jDateTime(false,true,'Asia/Tehran');

$dd=split("-",$min_date);

$dd=$temp_date_f->mktime(0,0,0,$dd[1],$dd[2],$dd[0],true);//reuse of dd :D
$date=$temp_date_f->date("Y-m",$dd);
$i=0;
?>
<table width="100%" class="Tables" border="1">
	<tr class="tablesheader">
		<td>ماه</td>
		<td>شهریه</td>
		<td>حقوق اساتید</td>
		<td>حقوق کارکنان</td>
		<td>اجاره</td>
		<td>درامد</td>
	</tr>
<?php
while ($date<=$max_date)
{
	$dd=$temp_date_f->mktime(0,0,0,$temp_date_f->date("m",$dd),1,$temp_date_f->date("Y",$dd),true);//reuse of dd :D
	$date=$temp_date_f->date("Y-m",$dd);
	$dd=strtotime("+35 days", $dd); 	
	
	
	$month_index_arr[$date]=$i++;
	?>
	<tr>
	<td><?php echo $date; ?></td>
	<td><?php echo price_english($arr1[$date]); ?></td>
	<td><?php echo price_english($arr2[$date]); ?></td>
	<td><?php echo price_english($arr3[$date]); ?></td>
	<td><?php echo price_english($arr4[$date]); ?></td>
	
	
	<td><?php echo price_english($arr1[$date]-$arr2[$date]-$arr3[$date]-$arr4[$date]); ?></td>
	</tr>
<?php
}
?>
</table>