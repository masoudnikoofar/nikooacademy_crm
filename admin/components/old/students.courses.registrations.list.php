<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<table class="tables" width="100%">
	<tr>
		<td align="center">
			<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=registrations.add">
				<img src="../images/buttons/register.png" border="0">
				<br/>
				ثبت نام ترم جدید
			</a>
		</td>
		<td align="center">
			<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses">
				<img src="../images/buttons/back.png" border="0">
				<br/>
				صفحه قبل
			</a>
		</td>
	</tr>
</table>





<table class="tableslistr" width="100%" border ="1">
	<tr class="tablesheader">
		<td rowspan="2">ردیف</td>
		<td rowspan="2">ترم</td>
		<td rowspan="2">شهریه</td>
		<td rowspan="2">شهریه هر جلسه</td>
        <td rowspan="2">تاریخ</td>
		<td rowspan="2">زمانبندی کلاس ها</td>
		<td colspan="7">اطلاعات پرداخت</td>
		<td rowspan="2">پرداخت</td>
		<td rowspan="2">سهم استاد</td>
		<td rowspan="2">توضیحات</td>
		<td rowspan="2">ویرایش</td>
		<td rowspan="2">حذف</td>
	</tr>
	<tr class="tablesheader">
		<td>تاریخ</td>
		<td>مبلغ پرداختی</td>
		<td>تعداد جلسات</td>
		<td>شیوه پرداخت</td>
		<td>توضیحات</td>
		<td colspan="2">ویرایش</td>
	</tr>
	<?php
	$db->query("select * from students_courses_registrations where student_course_id='".$student_course_id."' order by id desc");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{	
		$db->query("select count(*) as count,sum(payment_amount) as sum_payment_amount,sum(session_numbers) as sum_session_numbers from students_courses_registrations_payments where student_course_registration_id='".$row['id']."'");
		$res_tmp=$db->result();
		$row_tmp=$res_tmp[0];
		$rowspan=$row_tmp['count']+1;
		$sum_payment_amount=$row_tmp['sum_payment_amount'];
		$sum_session_numbers=$row_tmp['sum_session_numbers'];s
		?>
		<tr>
			<td rowspan=<?php echo $rowspan; ?>><?php echo $i++; ?></td>
			<td rowspan=<?php echo $rowspan; ?>>
				<?php 
				$db->query("select * from semesters where id='".$row['semester_id']."'");
				$res_tmp=$db->result();
				$row_tmp=$res_tmp[0];
				echo $row_tmp['title'];
				?>
			</td>
			<td rowspan=<?php echo $rowspan; ?>>
				<?php echo $row['tuition_fee']; ?>
				<br/>
				(درصد تخفیف: <?php echo $row['tuition_fee_off_percent']; ?>%)
			</td>
            <td rowspan=<?php echo $rowspan; ?>><?php echo $row['tuition_fee_per_session']; ?></td>
            <td rowspan=<?php echo $rowspan; ?>><?php echo $row['date']; ?></td>
			<td rowspan=<?php echo $rowspan; ?>><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $row['id']; ?>&func2=registrations.schedule"><img src="../images/buttons/schedule.png" border="0"></a></td>
			<td>جمع:</td>
			<td><?php echo $sum_payment_amount; ?></td>
			<td><?php echo $sum_session_numbers; ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
			<td rowspan=<?php echo $rowspan; ?>><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $row['id']; ?>&func2=registrations.payments&func3=add"><img src="../images/buttons/payments.png" border="0"></a></td>
			<td rowspan=<?php echo $rowspan; ?>><?php echo $row['teacher_share']; ?>%</td>
			
			<td rowspan=<?php echo $rowspan; ?>><?php echo $row['comment']; ?></td>
			<td rowspan=<?php echo $rowspan; ?>><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $row['id']; ?>&func2=registrations.edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
			<td rowspan=<?php echo $rowspan; ?>><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_registration_id=<?php echo $row['id']; ?>&func2=registrations.delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
		</tr>
		<?php
			$db->query("select * from students_courses_registrations_payments where student_course_registration_id='".$row['id']."'");
			$res_tmp=$db->result();
			foreach ($res_tmp as $row_tmp)
			{
				?>
				<tr class="odd">
					<td><?php echo $row_tmp['date']; ?></td>
					<td><?php echo $row_tmp['payment_amount']; ?></td>
					<td><?php echo $row_tmp['session_numbers']; ?></td>
					<td><?php echo ($row_tmp['payment_method']=="1"?"نقدی":"دستگاه کارتخوان"); ?></td>
					<td><?php echo $row_tmp['comment']; ?></td>
					<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $student_course_id; ?>&func2=registrations.payments&func3=edit&student_course_registration_payment_id=<?php echo $row_tmp['id']; ?>"><img src="../images/buttons/edit2.png" border="0"></a></td>
					<td><a href='#' onclick="confirm_delete('<?php echo $row_tmp['id']; ?>','index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $student_course_id; ?>&func2=registrations.payments&func3=delete&student_course_registration_payment_id=<?php echo $row_tmp['id']; ?>')"><img src="../images/buttons/delete2.png" border="0"></a></td>
				</tr>
				<?php
			}
			?>
		<?php
	}
	?>
</table>