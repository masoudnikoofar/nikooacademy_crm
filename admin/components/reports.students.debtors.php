<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$db->query("SELECT
	a.student_id,
	c.firstname AS student_firstname,
	c.lastname AS student_lastname,
	b.title AS course_title,
	b.discount_rate AS course_discount_rate,
	a.discount_rate AS course_student_discount_rate,
	b.discount_rate + a.discount_rate AS total_discount_rate,
	b.tuition_fee,
	b.tuition_fee - b.tuition_fee * ( b.discount_rate + a.discount_rate ) / 100 AS payable_amount,
	b.tuition_fee * ( b.discount_rate + a.discount_rate ) / 100 AS discount_amount,
	sum( d.payment_amount ) AS student_payment_amount,
	b.tuition_fee - b.tuition_fee * ( b.discount_rate + a.discount_rate ) / 100 - IFNULL( sum( d.payment_amount ), 0 ) AS remained_amount 
FROM
	courses_students a
	JOIN courses b ON a.course_id = b.id
	JOIN students c ON a.student_id = c.id
	LEFT JOIN courses_students_payments d ON a.id = d.course_student_id 
GROUP BY
	c.firstname,
	c.lastname,
	b.title,
	b.discount_rate,
	a.discount_rate 
HAVING
	b.tuition_fee - b.tuition_fee * ( b.discount_rate + a.discount_rate ) / 100 - IFNULL( sum( d.payment_amount ), 0 ) >0
");
$res=$db->result();
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="8">لیست دانشجویان بدهکار</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دانشجو</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
		<td>شهریه</td>
		<td>درصد تخفیف (دوره + دانشجو)</td>
		<td>مبلغ پرداختی</td>
		<td>مبلغ بدهی</td>
	</tr>
	<?php
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><a href="index.php?pid=students&student_id=<?php echo $row['student_id']; ?>&func=courses" target="_blank"><?php echo $row['student_firstname']." ".$row['student_lastname']; ?> (<?php echo $row['student_id']; ?>)</a></td>
			<td><?php echo $row['course_title']; ?></td>
			<td><?php echo $row['teacher_fullname']; ?></td>
			<td><?php echo $row['tuition_fee'];?></td>
			<td><?php echo $row['total_discount_rate']." (".$row['course_discount_rate']."+".$row['course_student_discount_rate'].")"; ?></td>
			<td><?php echo $row['student_payment_amount']; ?></td>
			<td><?php echo $row['remained_amount']; ?></td>
		</tr>
		<?php
	}
	?>	
</table>