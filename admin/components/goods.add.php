<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
	$good_id=$_POST['good_id'];
	
	$good_name=$_POST['good_name'];
	$number=$_POST['number'];
	$price_one_buy=$_POST['price_one_buy'];
	$price_one_sell=$_POST['price_one_sell'];
	$unit=$_POST['unit'];
	$good_service=$_POST['good_service'];
	
	$invoice_date=$_POST['invoice_date'];
	$invoice_no_buy=$_POST['invoice_no_buy'];
	
	
    if ($good_id=="")
	{		
        $db->query("insert into goods set
		name='".$good_name."',
		number='".$number."',
		price_one_buy='".$price_one_buy."',
		price_one_sell='".$price_one_sell."',
		unit='".$unit."',
		good_service='".$good_service."'");
		
		
		$db->query("select last_insert_id() as id");
		$res=$db->result();
		$good_id=$res[0]['id'];
		
		$good_log_args=array(
			"transaction_type"=>1,
			"invoice_date"=>$invoice_date,
			"good_id"=>$good_id,
			"number"=>$number,
			"price_one_buy"=>$price_one_buy,
			"price_one_sell"=>$price_one_sell,
			"invoice_no_buy"=>$invoice_no_buy,
			/*
			"student_id"=>$student_id,
			"student_invoice_id"=>$student_invoice_id,
			*/
			"comment"=>$comment
		);
		good_log($good_log_args);
	}
    else
	{
        $db->query("update goods set number=number+".$number." where id='".$good_id."'");
		
		if ($price_one_buy>0)
			$db->query("update goods set price_one_buy='".$price_one_buy."' where id='$good_id'");
		if ($price_one_sell>0)
			$db->query("update goods set price_one_sell='".$price_one_sell."' where id='$good_id'");
		
		
		$good_log_args=array(
			"transaction_type"=>2,
			"invoice_date"=>$invoice_date,
			"good_id"=>$good_id,
			"number"=>$number,
			"price_one_buy"=>$price_one_buy,
			"price_one_sell"=>$price_one_sell,
			"invoice_no_buy"=>$invoice_no_buy,
			/*
			"student_id"=>$student_id,
			"student_invoice_id"=>$student_invoice_id,
			*/
			"comment"=>$comment
		);
		good_log($good_log_args);
	}
    alert("با موفقیت اضافه شد");
}
?>
<script>
function change()
{
    if(document.getElementById('good_id').value!="")
    {
        document.getElementById('new_good').style.display="none";
    }
    else
    {
        document.getElementById('new_good').style.display="block";
    }
}
</script>


<form method="post" enctype="multipart/form-data">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables" >
<tr><td colspan="2" class="tablesheader">اضافه کردن کالای جدید</td></tr>
<tr>
    <td align="left"><b>نام کالا:</b></td>
    <td>
        <select name="good_id" id="good_id" onchange="change()">
			<option value="">کالای جدید</option>
			<?php
			$db->query("select * from goods order by name");
			$res=$db->result();
			foreach ($res as $row)
			{
				echo "<option value='$row[id]'>$row[name]</option>";
			}
			?>
			</select>
        <input type="text" name="good_name" id="new_good" style="display:block">
    </td>
</tr>
<tr><td align="left"><b>سریال:</b></td><td><input type="text" name="serial_no"></td></tr>
<tr><td align="left"><b>تعداد:</b></td><td><input type="text" name="number"></td></tr>
<tr><td align="left"><b>قیمت خرید تک:</b></td><td><input type="text" name="price_one_buy"> ریال</td></tr>
<tr><td align="left"><b>قیمت فروش تک:</b></td><td><input type="text" name="price_one_sell"> ریال</td></tr>
<tr><td align="left"><b>واحد اندازه گیری:</b></td><td><input type="text" name="unit"></td></tr>
<tr>
	<td align="left"><b>نوع:</b></td>
	<td>
		کالا <input type="radio" name="good_service" value="0"> 
		خدمت <input type="radio" name="good_service" value="1">
	</td>
</tr>
<tr><td align="left"><b>تاریخ:</b></td><td><input type="text" name="invoice_date" value="<?php echo $today; ?>"><?php calendar("invoice_date"); ?></td></tr>
<tr><td align="left"><b>شماره فاکتور خرید:</b></td><td><input type="text" name="invoice_no_buy"></td></tr>
<tr><td colspan="2" align="center"><button type="submit">اضافه</button></td></tr>
</table>
</form>