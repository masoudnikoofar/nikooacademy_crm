<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$student_id=$db->mysql_real_escape_string($_GET['student_id']);
$invoice_id=$_POST['invoice_id'];
$date=$_POST['date'];
$time=$_POST['time'];
$price=$_POST['price'];
$number=$_POST['number'];

$good_id=$_POST['good_id'];
$person_id=$_POST['person_id'];

if ($_POST[step]=="2")
{
	if ($invoice_id=="new")
	{
		$db->query("insert into invoices set buyer_id='$student_id',date='$date',time='$time'");
		$db->query("select * from invoices where buyer_id='$student_id' order by id desc");
		$res=$db->result();
		$invoice_id=$res[0]['id'];
	}
	$db->query("select * from invoices where id='$invoice_id'");
	$res=$db->result();
	$row=$res[0];

	if ($_POST['is_gift']=="on")
	{
		$is_gift="1";
	}
	else
	{
		$is_gift="0";
	}
	
	$db->query("insert into invoices_goods set 
	invoice_id='".$invoice_id."',
	good_id='".$good_id."',
	number='".$number."',
	date='".$date."',
	time='".$time."',
	price='".$price."',
	is_gift='".$is_gift."'
	");
	
	$db->query("update goods set number=number-".$number." where id='".$good_id."'");
	
	$good_log_args=array(
			"transaction_type"=>3,
			"invoice_date"=>$date,
			"good_id"=>$good_id,
			"number"=>(-1*$number),
			//"price_one_buy"=>$price_one_buy,
			"price_one_sell"=>$price,
			//"invoice_no_buy"=>$invoice_no_buy,
			
			"buyer_id"=>$student_id,
			"buyer_invoice_id"=>$invoice_id
		);
		good_log($good_log_args);
	
	alert("با موفقیت اضافه شد");
	popup_close();
}
?>

<form method="post">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="100%">
		<tr><td colspan="2" class="tablesheader">اضافه کردن کالای جدید</td></tr>
		<tr>
			<td align="left"><b>فاکتور:</b></td>
			<td>
				<select name="invoice_id">
					<?php
					$db->query("select * from invoices where buyer_id='$student_id' order by id desc");
					$res=$db->result();
					foreach ($res as $row)
					{
						echo "<option value='$row[id]'>فاکتور شماره $row[id]</option>";
					}
					?>
					<option value="new">فاکتور جدید</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left"><b>نام کالا:</b></td>
			<td>
				<select name="good_id" id="good_id">
					<option value="">--انتخاب کنید--</option>
					<?php
					$db->query("select * from goods where is_old=0 order by name");
					$res=$db->result();
					foreach ($res as $row)
					{
						?>
						<option value='<?php echo $row['id']; ?>'><?php echo $row['name']."(موجود:".$row['number']." ".$row['unit'].")"; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr><td align="left"><b>تعداد:</b></td><td><input type="text" name="number" value="1"></td></tr>
		<tr><td align="left"><b>تاریخ:</b></td><td><input type="text" name="date" value="<?php echo $today; ?>" dir="ltr"><?php calendar("date"); ?></td></tr>
		<tr><td align="left"><b>ساعت:</b></td><td><input type="text" name="time" value="<?php echo $today_time; ?>" dir="ltr"></td></tr>
		<tr><td align="left"><b>قیمت:</b></td><td><input type="text" name="price" id="price"></td></tr>
		<tr><td align="left"><b>هدیه:</b></td><td><input type="checkbox" name="is_gift"></td></tr>
		<tr><td colspan="2" align="center"><button type="submit">اضافه</button></td></tr>
	</table>
</form>
<script>
<?php
$db->query("select * from goods order by name");
$res=$db->result();
?>
var goods = new Array();
$(document).ready(function() {
	<?php
	$i=0;
	foreach ($res as $row)
	{
		?>
		goods['<?php echo $row['id']; ?>']= '<?php echo $row['price_one_sell']; ?>';
		<?php
		$i++;
	}	
	?>
	$('#price').val(goods[0]);
});
$('#good_id').change(function() {
	$('#price').val(goods[$('#good_id').val()]);
});
</script>