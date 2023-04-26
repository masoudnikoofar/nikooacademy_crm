<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['person_id']))
{
	$person_id=$db->mysql_real_escape_string($_GET['person_id']);
}
if (isset($_GET['month']))
{
	$month=$db->mysql_real_escape_string($_GET['month']);
}

$db->query("select id from people_payments where
person_id='".$person_id."' and
month='".$month."'
");
$res=$db->result();
$row=$res[0];
$person_payment_id=$row['id'];

if ($_POST['step']=="2")
{
	if ($person_payment_id=="")
	{
		$db->query("insert into people_payments set 
		person_id='".$person_id."',
		month='".$month."',
		payment_info='".$_POST['payment_info']."',
		payment_date='".$_POST['payment_date']."',
		payment_type='".$_POST['payment_type']."',
		comment='".$_POST['comment']."'
		");
		alert("با موفقیت اضافه شد");
	}
	else
	{
		$db->query("update people_payments set 

		month='".$month."',
		payment_info='".$_POST['payment_info']."',
		payment_date='".$_POST['payment_date']."',
		payment_type='".$_POST['payment_type']."',
		comment='".$_POST['comment']."'
		where 
		person_id='".$person_id."'
		and month='".$month."'
		");
		alert("با موفقیت ویرایش شد");
	}
}
else
{
	$db->query("select * from people_payments where
	person_id='".$person_id."' and
	month='".$month."'
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