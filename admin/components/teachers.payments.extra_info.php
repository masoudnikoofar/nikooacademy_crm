<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['teacher_id']))
{
	$teacher_id=$db->mysql_real_escape_string($_GET['teacher_id']);
}
if (isset($_GET['semester_id']))
{
	$semester_id=$db->mysql_real_escape_string($_GET['semester_id']);
}
if (isset($_GET['class_date_month']))
{
	$class_date_month=$db->mysql_real_escape_string($_GET['class_date_month']);
}

$db->query("select id from teachers_payments where
teacher_id='".$teacher_id."' and
semester_id='".$semester_id."' and
class_date_month='".$class_date_month."'
");
$res=$db->result();
$row=$res[0];
$teacher_payment_id=$row['id'];

if ($_POST['step']=="2")
{
	if ($teacher_payment_id=="")
	{
		$db->query("insert into teachers_payments set 
		semester_id='".$semester_id."',
		teacher_id='".$teacher_id."',
		class_date_month='".$class_date_month."',
		payment_info='".$_POST['payment_info']."',
		payment_date='".$_POST['payment_date']."',
		payment_type='".$_POST['payment_type']."',
		comment='".$_POST['comment']."'
		");
		alert("با موفقیت اضافه شد");
	}
	else
	{
		$db->query("update teachers_payments set 

		class_date_month='".$class_date_month."',
		payment_info='".$_POST['payment_info']."',
		payment_date='".$_POST['payment_date']."',
		payment_type='".$_POST['payment_type']."',
		comment='".$_POST['comment']."'
		where 
		semester_id='".$semester_id."' 
		and teacher_id='".$teacher_id."'
		and class_date_month='".$class_date_month."'
		");
		alert("با موفقیت ویرایش شد");
	}
}
else
{
	$db->query("select * from teachers_payments where
	teacher_id='".$teacher_id."' and
	semester_id='".$semester_id."' and
	class_date_month='".$class_date_month."'
	");
	$res=$db->result();
	
	$row=$res[0];
	$payment_type=$row['payment_type'];
	$payment_date=$row['payment_date'];
	$payment_info=$row['payment_info'];
	$comment=$row['comment'];
	?>
	<table class="tables">
	<form method="post">
		<input type="hidden" name="step" value="2">
		<tr>
			<td align="left"><b>تاریخ پرداخت:</b></td>
			<td><input type="text" name="payment_date" value=<?php echo $payment_date; ?>><?php calendar("payment_date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>روش پرداخت:</b></td>
			<td>
				<input type="radio" name="payment_type" value="1" <?php if ($payment_type=="1") echo "checked"; ?>> نقدی
				<input type="radio" name="payment_type" value="2" <?php if ($payment_type=="2") echo "checked"; ?>> انتقال وجه کارت به کارت
			</td>
		</tr>
		<tr>
			<td align="left"><b>اطلاعات پرداخت:</b></td>
			<td>
				<input type="text" name="payment_info" value=<?php echo $payment_info; ?>>
			</td>
		</tr>
		<tr>
			<td align="left"><b>توضیحات:</b></td>
			<td>
				<textarea name="comment"><?php echo $comment; ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<button type="submit">ثبت</button>
			</td>
		</tr>
	</form>
	<?php
}
?>