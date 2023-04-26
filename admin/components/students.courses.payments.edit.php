<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$student_course_registration_payment_id=$db->mysql_real_escape_string($_GET['student_course_registration_payment_id']);

if ($_POST['step']=="2")
{
	$db->query("update students_courses_registrations_payments set
		payment_amount='".$_POST['payment_amount']."',
		payment_method='".$_POST['payment_method']."',
		session_numbers='".$_POST['session_numbers']."',
		date='".$_POST['date']."',
		comment='".$_POST['comment']."'
		where id='".$student_course_registration_payment_id."'");
	alert("با موفقیت ثبت شد");
}

$db->query("select * from students_courses_registrations_payments where id='".$student_course_registration_payment_id."'");
$res=$db->result();
$row=$res[0];
?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="100%">
		<tr>
			<td align="left"><b>تاریخ:</b></td>
			<td><input type="text" name="date" dir="ltr" value="<?php echo $row['date']; ?>"><?php calendar("date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>تعداد جلسات:</b></td>
			<td><input type="text" name="session_numbers" value="<?php echo $row['session_numbers']; ?>"></td>
		</tr>
		<tr>
			<td align="left"><b>مبلغ پرداختی:</b></td>
			<td><input type="text" name="payment_amount" value="<?php echo $row['payment_amount']; ?>"></td>
		</tr>
		<tr>
			<td align="left"><b>شیوه پرداخت:</b></td>
			<td>
				<input type="radio" name="payment_method" value="1" <?php if($row['payment_method']=="1") echo "checked"; ?>> نقدی<br/>
				<input type="radio" name="payment_method" value="2" <?php if($row['payment_method']=="2") echo "checked"; ?>> دستگاه کارتخوان
			</td>
		</tr>
		<tr>
			<td align="left"><b>توضیحات:</b></td>
			<td><textarea name="comment"><?php echo $row['comment']; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>