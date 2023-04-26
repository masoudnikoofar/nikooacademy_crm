<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>



<script>
$(function () {
	$('#container').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'نمودار هزینه/درآمد'
		},
		xAxis: {
			categories: ["درآمد","صاحب دوره","استاد","صادرکننده گواهی","سایر"],
			style: {
					//fontWeight: 'bold',
					font:"Tahoma",
					color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
				}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'ریال',
				align: 'high'
			},
			stackLabels: {              
				enabled: true,
				rotation: 0,
				style: {
					//fontWeight: 'bold',
					fontFamily:"Tahoma",
					color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
				}
			}
		},
		tooltip: {
			formatter: function () {
				return '<b>' + this.x + '</b><br/>' +
					this.series.name + ': ' + this.y;
			}
		},

		plotOptions: {
			column: {
				stacking: 'normal',
				colorByPoint: true
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
			$db->query('select 
						"درآمد" as title,sum(a.payment_amount) as amount,1 as positive_negative
						from courses_students_payments a
						union all
						select "صاحب دوره" as title,sum(x.payment_amount*z.course_owner_tuition_share/100) as amount,-1 as positive_negative from courses_students_payments x,courses_students y,courses z
						where x.course_student_id=y.id
						and y.course_id=z.id
						union all
						select "استاد" as title,sum(x.payment_amount*z.teacher_tuition_share/100) as amount,-1 as positive_negative from courses_students_payments x,courses_students y,courses z
						where x.course_student_id=y.id
						and y.course_id=z.id
						union all
						select "صادرکننده گواهی" as title,sum(x.payment_amount*z.certificate_tuition_share/100) as amount,-1 as positive_negative from courses_students_payments x,courses_students y,courses z
						where x.course_student_id=y.id
						and y.course_id=z.id
						union all
						select "سایر" as title,sum(q.amount) as amount,-1 as positive_negative from
						other_costs q');
			$res=$db->result();
			$i=1;
			foreach ($res as $row)
			{
				?>
				["<?php echo $row['title']; ?>",<?php echo $row['amount']; ?>],
				<?php
			}
			?>
			],
			dataLabels: {
				enabled: false,
				rotation: 0,
				color: '#FFFFFF',
				align: 'right',
				format: '{point.y:.0f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '10px',
					fontFamily: 'Tahoma, sans-serif'
				}
			}
			,stack: 'درآمد'
		},
		
		
		
			]
	});
});

</script>
<div id="container" style="min-width: 310px; min-height: 500px; margin: 0 auto;direction:ltr"></div>

