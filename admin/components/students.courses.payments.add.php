<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST['step']=="2")
{
	$db->query("insert into courses_students_payments set
		course_student_id='".$course_student_id."',
		payment_amount='".$_POST['payment_amount']."',
		payment_method='".$_POST['payment_method']."',
		payment_date='".$_POST['payment_date']."',
		payment_description='".$_POST['payment_description']."'");
	alert("با موفقیت ثبت شد");
}
?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="100%">
		<tr>
			<td align="left"><b>تاریخ:</b></td>
			<td><input type="text" name="payment_date" dir="ltr" value="<?php echo $today; ?>"><?php calendar("payment_date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>مبلغ پرداختی:</b></td>
			<td><input type="text" name="payment_amount"></td>
		</tr>
		<tr>
			<td align="left"><b>شیوه پرداخت:</b></td>
			<td>
				<input type="radio" name="payment_method" value="1">کارت به کارت<br/>
				<input type="radio" name="payment_method" value="2">درگاه پرداخت<br/>
				<input type="radio" name="payment_method" value="3">کارتخوان<br/>
				<input type="radio" name="payment_method" value="4">نقدی
			</td>
		</tr>
		<tr>
			<td align="left"><b>توضیحات:</b></td>
			<td><textarea name="payment_description"></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>