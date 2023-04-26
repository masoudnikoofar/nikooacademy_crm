<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<table class="tables">
		<tr>
			<td align="left"><b>تاریخ شروع:</b><td>
			<td><input type="text" name="min_date"><?php calendar("min_date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>تاریخ پایان:</b><td>
			<td><input type="text" name="max_date"><?php calendar("max_date"); ?></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">گزارش</button></td>
		</tr>		
	</table>
</form>

<?php
if ($_POST['step']=="2")
{
	
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
	?>
	<script>
	$(function () {
		$('#container').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: 'نمودار درآمد هر ماه'
			},
			xAxis: {
				categories: [
				<?php
				$month_index_arr="";
				$temp_date_f=new jDateTime(false,true,'Asia/Tehran');
				
				$dd=split("-",$min_date);

				$dd=$temp_date_f->mktime(0,0,0,$dd[1],$dd[2],$dd[0],true);//reuse of dd :D
				$date=$temp_date_f->date("Y-m",$dd);
				$i=0;
				while ($date<=$max_date)
				{
					

					$dd=$temp_date_f->mktime(0,0,0,$temp_date_f->date("m",$dd),1,$temp_date_f->date("Y",$dd),true);//reuse of dd :D
					$date=$temp_date_f->date("Y-m",$dd);
					$dd=strtotime("+35 days", $dd); 	
					
					echo "'".$date."',";
					
					$month_index_arr[$date]=$i++;
				}
				
				?>
				]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'درآمد (ریال)',
					align: 'high'
				},
				stackLabels: {              
					enabled: true,
					rotation: -90,
					style: {
						//fontWeight: 'bold',
						color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
					}
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.x + '</b><br/>' +
						this.series.name + ': ' + this.y + '<br/>' +
						'جمع: ' + this.point.stackTotal;
				}
			},

			plotOptions: {
				column: {
					stacking: 'normal'
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [
			{
				name: 'درآمد',
				data: [
				<?php
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
				$i=1;
				foreach ($res as $row)
				{
					?>
					[<?php  echo $month_index_arr[$row['month']]; ?>,<?php echo $row['sum_payment_amount']; ?>],
					<?php
				}
				?>
				],
				dataLabels: {
					enabled: false,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y:.0f}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '10px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
				,stack: 'درآمد'
			},
			{
				name: 'حقوق اساتید',
				data: [
				<?php
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
				$i=1;
				foreach ($res as $row)
				{
					?>
					[<?php  echo $month_index_arr[$row['month']]; ?>,<?php echo $row['teachers_salary']; ?>],
					<?php
				}
				?>
				],
				dataLabels: {
					enabled: false,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y:.0f}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '10px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
				,stack: 'هزینه'
			}
			,
			{
				name: 'حقوق کارمندان',
				data: [
				<?php
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
					?>
					[<?php  echo $month_index_arr[$row['month']]; ?>,<?php echo $row['sum_wage']; ?>],
					<?php
				}
				?>
				],
				dataLabels: {
					enabled: false,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y:.0f}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '10px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
				,stack: 'هزینه'
			},
			{
				name: 'سایر',
				data: [
				<?php
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
					?>
					[<?php  echo $month_index_arr[$row['month']]; ?>,<?php echo $row['amount']; ?>],
					<?php
				}
				?>
				],
				dataLabels: {
					enabled: false,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y:.0f}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '10px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
				,stack: 'هزینه'
			},
			
			
				]
		});
	});
	</script>
	<div id="container" style="min-width: 310px; min-height: 500px; margin: 0 auto;direction:ltr"></div>
<?php
include("components/reports.income_per_month_without_2.php");
}
?>
