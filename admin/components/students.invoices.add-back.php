<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$student_id=$_GET['student_id'];

if ($_POST[step]=="2")
{
	if ($_POST['final']=="0")
		$final="0";
	else
		$final="1";
	if ($_POST['payment']=="0")
		$payment="0";
	else
		$payment="1";
   
	$db->query("insert into invoices set 
	buyer_id='$student_id',
    off='".$_POST['off']."',
    payment='$payment',
    final='$final'
    ");
    alert("با موفقیت اضافه شد");
}

?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables" >
<tr><td colspan="2" class="tablesheader">اضافه کردن فاکتور</td></tr>
<tr>
    <td align="left"><b>تخفیف:</b></td>
    <td>
        <input type="text" name="off"> ریال
    </td>
</tr>
<tr>
    <td align="left"><b>دریافت:</b></td>
    <td>
        نقدی <input type="radio" name="payment" value="0" checked>
        غیرنقدی <input type="radio" name="payment" value="1">
    </td>
</tr>
<tr>
    <td align="left"><b>وضعیت:</b></td>
    <td>
        غیرنهایی <input type="radio" name="final" value="0" checked>
        نهایی <input type="radio" name="final" value="1">
    </td>
</tr>
<tr><td colspan="2" align="center"><button type="submit">افزودن</button></td></tr>
</table>
</form>