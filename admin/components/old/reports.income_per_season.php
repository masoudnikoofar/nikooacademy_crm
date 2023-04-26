<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'نمودار درآمد هر فصل'
        },
        xAxis: {
			categories: [
			<?php
			$db->query("select * from semesters order by id");
			$res=$db->result();
			foreach ($res as $row)
			{
				echo "'".$row['title']."',";
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
			labels: {
				overflow: 'justify'
			}
		},
        tooltip: {
            valueSuffix: 'ریال'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
			name: 'درآمد',
			data: [
			<?php
			$db->query("
			select 
			a.semester_id,sum(b.payment_amount) as sum_payment_amount
			from students_courses_registrations a,
			students_courses_registrations_payments b
			where a.id=b.student_course_registration_id
			group by a.semester_id
			order by a.semester_id
			");
			$res=$db->result();
			$i=1;
			foreach ($res as $row)
			{
				echo $row['sum_payment_amount'].",";
			}
			?>
			],
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				format: '{point.y:.0f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
			},
			{
			name: 'حقوق اساتید',
			data: [
			<?php
			$db->query("
				select
				b.semester_id,
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
				and c.class_date>=f.start_date and c.class_date<=f.end_date
				group by b.semester_id
				order by b.semester_id
			");
			$res=$db->result();
			$i=1;
			foreach ($res as $row)
			{
				echo $row['teachers_salary'].",";
			}
			?>
			],
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				format: '{point.y:.0f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
			}]
    });
});
</script>
<div id="container" style="min-width: 310px; min-height: 500px; margin: 0 auto;direction:ltr"></div>
