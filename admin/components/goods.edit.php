<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
	if ($_POST['is_old']=="on")
	{
		$is_old=1;
	}
	else
	{
		$is_old=0;
	}
    $db->query("update goods set 
	name='".$_POST['name']."',
	serial_no='".$_POST['serial_no']."',
	unit='".$_POST['unit']."',
	number='".$_POST['number']."',
	price_one_buy='".$_POST['price_one_buy']."',
	price_one_sell='".$_POST['price_one_sell']."',
	good_service='".$_POST['good_service']."',
	is_old='".$is_old."' 
	where id='$good_id'");

    alert("با موفقیت ویرایش شد");
    goback("index.php?pid=goods");
}
$db->query("select * from goods where id='$good_id'");
$res=$db->result();
$row=$res[0];
?>
<form method="post">
	<input type="hidden" name="step" value="2">
	<table width="60%" class="tables">
		<tr><td colspan="2" class="tablesheader">ویرایش کالا</td></tr>
		<tr><td align="left"><b>نام:</b></td><td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td></tr>
		<tr><td align="left"><b>سریال:</b></td><td><input type="text" name="serial_no" value="<?php echo $row['serial_no']; ?>"></td></tr>
		<tr><td align="left"><b>تعداد:</b></td><td><input type="text"" name="number" value="<?php echo $row['number']; ?>"></td></tr>
		<tr><td align="left"><b>قیمت خرید تک:</b></td><td><input type="text"" name="price_one_buy" value="<?php echo $row['price_one_buy']; ?>"> ریال</td></tr>
		<tr><td align="left"><b>قیمت فروش تک:</b></td><td><input type="text"" name="price_one_sell" value="<?php echo $row['price_one_sell']; ?>"> ریال</td></tr>
		<tr><td align="left"><b>واحد اندازه گیری:</b></td><td><input type="text" name="unit" value="<?php echo $row['unit']; ?>"></td></tr>
	<tr>
		<td align="left"><b>نوع:</b></td>
		<td>
			کالا <input type="radio" name="good_service" value="0" <?php if ($row['good_service']=="0") echo "checked"; ?>> 
			خدمت <input type="radio" name="good_service" value="1" <?php if ($row['good_service']=="1") echo "checked"; ?>>
		</td>
	</tr>
	<tr>
		<td align="left"><b>کالای قدیمی:</b></td>
		<td>
			<input type="checkbox" name="is_old" <?php if ($row['is_old']=="1") echo "checked"; ?>> 
		</td>
	</tr>

	<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
	</table>
</form>


<?php
include("components/goods.edit.log.php");
?>