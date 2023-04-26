<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<a href="index.php?pid=students&func=courses&course_student_id=<?php echo $course_student_id; ?>&func2=payments&func3=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن پرداخت جدید</a><br />

<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td>تاریخ</td>
		<td>مبلغ پرداختی</td>
		<td>شیوه پرداخت</td>
		<td>توضیحات</td>
	</tr>
	<?php
	$db->query("select * from courses_students_payments where course_student_id='".$course_student_id."'");
	$res=$db->result();
	$payed_amount = 0;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $row['payment_date']; ?></td>
			<td><?php echo $row['payment_amount']; ?></td>
			<td>
				<?php 
				switch ($row['payment_method']) {
					case 1:
						echo "کارت به کارت";
						break;
					case 2:
						echo "درگاه پرداخت";
						break;
					case 3:
						echo "کارتخوان";
						break;
					case 4:
						echo "نقدی";
						break;
				}
				?>
			</td>
			<td><?php echo $row['payment_description']; ?></td>
		</tr>
		<?php
		$payed_amount += $row['payment_amount'];
	}
	?>
	<tr class="tablesheader">
		<td colspan="4">
			<?php
			$db->query("select * from courses_students where id='".$course_student_id."'");
			$res_tmp = $db->result();
			$row_tmp = $res_tmp[0];
			$course_id = $row_tmp['course_id'];
			$course_student_discount_rate = $row_tmp['discount_rate'];
			
			$db->query("select * from courses where id='".$course_id."'");
			$res_tmp = $db->result();
			$row_tmp = $res_tmp[0];
			$course_discount_rate = $row_tmp['discount_rate'];
			$course_tuition_fee = $row_tmp['tuition_fee'];
			$discount_rate = $course_discount_rate+$course_student_discount_rate;
			
			$payable_amount = $course_tuition_fee - $course_tuition_fee*($discount_rate)/100;
			
			?>
			<b>شهریه کلاس: </b> <?php echo $course_tuition_fee; ?> - 
			<b>درصد تخفیف : </b> <?php echo $discount_rate." (".$course_discount_rate." + ".$course_student_discount_rate.")"; ?> - 
			<b>قابل پرداخت: </b> <?php echo $payable_amount; ?> - 
			<b>پرداخت شده: </b> <?php echo $payed_amount; ?> - 
			<b>بدهی: </b> <?php echo $payable_amount-$payed_amount; ?>
		</td>
	</tr>
</table>
