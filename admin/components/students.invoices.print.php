<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php

//for popup
$student_id=$db->mysql_real_escape_string($_GET['student_id']);
$invoice_id=$db->mysql_real_escape_string($_GET['invoice_id']);

$db->query("select * from students where id='$student_id'");
$res=$db->result();
$row=$res[0];
$db->query("select * from people where id='$row[operator_id]'");
$res2=$db->result();
$operator=$res2[0]['name'];
$student_name=$row['firstname']." ".$row['lastname'];
$tel=$row['tel'];
?>
<table class="tables" width="100%">
    <tr class="odd" height="50"> 
        <td align="left" width="200"><b>نام و نام خانوادگی مشترک:</b></td>
        <td colspan="3"><?php echo $student_name; ?></td>
    </tr>
    <tr height="50">
        <td align="left"><b>تلفن :</b></td>
        <td><?php echo $row['tel']; ?></td>
        <td align="left"><b>تلفن همراه :</b></td>
        <td><?php echo $row['mobile']; ?></td>
    </tr>
    <tr class="odd" height="50">
        <td align="left"><b>آدرس :</b></td>
        <td colspan="3"><?php echo $row['address']; ?></td>
    </tr>
</table> 
<br />
<br />


<?php
$db->query("select * from invoices where buyer_id='".$student_id."' and id='".$invoice_id."'");
$res3=$db->result();
$row3=$res3[0];
$off=$row3['off'];
?>
<table class="tableslistr" width="100%" border="1">
    <tr height="50">
        <td colspan="11"><b>مشخصات کالا یا خدمات مورد معامله</b></td>
	</tr>
    <tr height="50">
        <td><b>ردیف</b></td>
        <td><b>کد کالا</b></td>
        <td><b>شرح کالا یا خدمات</b></td>
        <td><b>تعداد</b></td>
        <td><b>واحد اندازه گیری</b></td>
        <td><b>مبلغ واحد (ریال)</b></td>
        <td><b>مبلغ کل (ریال)</b></td>
        <td><b>مبلغ تخفیف (ریال)</b></td>
        <td><b>مبلغ کل پس از تخفیف (ریال)</b></td>
        <td><b>جمع مالیات و عوارض (ریال)</b></td>
        <td><b>جمع مبلغ کل به علاوه جمع مالیات و عوارض (ریال)</b></td>
    </tr>
<?php
$db->query("select * from invoices_goods where invoice_id='$invoice_id'");
$res=$db->result();
$i=1;
$total_price=0;
$good_price_sum=0;
$good_total_price_sum=0;
$good_off_sum=0;
$good_total_price_after_off_sum=0;
$good_tax_sum=0;
$good_total_price_after_all_sum=0;

$good_good_price_sum=0;
$good_service_price_sum=0;
foreach ($res as $row)
{
    $db->query("select * from goods where id='$row[good_id]'");
    $res2=$db->result();
    $row2=$res2[0];
    $good_price=$row[price];
	$good_number=$row[number];
	$good_unit=$row2[unit];
	$good_total_price=$good_number*$good_price;
	$good_off=0;//$off;
	$good_total_price_after_off=$good_total_price-$good_off;
	$good_tax=$good_total_price_after_off*$tax_rate;
	$good_total_price_after_all=$good_total_price_after_off+$good_tax;
	$total_price+=$row[price];
	$good_name=$row2[name];
	
	$good_price_sum+=$good_price;
	$good_total_price_sum+=$good_total_price;
	$good_off_sum+=$good_off;
	$good_total_price_after_off_sum+=$good_total_price_after_off;
	$good_tax_sum+=$good_tax;
	$good_total_price_after_all_sum+=$good_total_price_after_all;

	if ($row2['good_service']=="0")
	{
		$good_good_price_sum+=$good_total_price;
	}
	else
	{
		$good_service_price_sum+=$good_total_price;
	}
    ?>
    <tr height="50">
        <td><?php echo $i++; ?></td>
        <td><?php echo $row2[id]; ?></td>
        <td><?php echo $good_name; ?></td>
        <td><?php echo $good_number; ?></td>
        <td><?php echo $good_unit; ?></td>
        <td><?php echo $good_price; ?></td>
        <td><?php echo $good_total_price; ?></td>
		<td><?php echo $good_off; ?></td>
		<td><?php echo $good_total_price_after_off; ?></td>
		<td><?php echo $good_tax; ?></td>
		<td><?php echo $good_total_price_after_all; ?></td>
    </tr>
    <?php
}
?>
<tr height="50">
    <td colspan="5"><b>جمع کل:</b></td>
	<td><?php echo $good_price_sum; ?></td>
	<td><?php echo $good_total_price_sum; ?></td>
	<td><?php echo $good_off_sum; ?></td>
	<td><?php echo $good_total_price_after_off_sum; ?></td>
	<td><?php echo $good_tax_sum; ?></td>
	<td><?php echo $good_total_price_after_all_sum; ?></td>
</tr>
<tr height="50">
    <td colspan="5">
		<b>تاریخ چاپ فاکتور<br/>
		تاریخ صدور فاکتور</b>
	</td>
	<td colspan="4" dir="ltr">
		<?php echo $today." ".$today_time; ?><br/>
		<?php echo $row3['date']." ".$row3['time']; ?>
	</td>
	<td><b>جمع کالا</b></td>
	<td><?php echo $good_good_price_sum; ?></td>
</tr>

<tr height="50">
    <td colspan="5"><b>توضیحات:</b></td>
    <td colspan="4"></td>
	<td><b>جمع خدمات</b></td>
	<td><?php echo $good_service_price_sum; ?></td>
</tr>
<tr height="50">
    <td colspan="5" rowspan="4"><b>مهر و امضاء فروشنده</b></td>
    <td colspan="4" rowspan="4"><b>مهر و امضاء خریدار</b></td>
	<td><b>جمع کالا و خدمات</b></td>
	<td><?php echo $good_total_price_sum; ?></td>
</tr>
<tr height="50">
	<td><b>مبلغ تخفیف</b></td>
	<td><?php echo $off;//$good_off_sum; ?></td>
</tr>
<tr height="50">
	<td><b>عوارض و مالیات</b></td>
	<td><?php echo $good_tax_sum; ?></td>
</tr>
<tr height="50">
	<td><b>قابل پرداخت</b></td>
	<td><?php echo $good_total_price_after_all_sum - $off; ?></td>
</tr>
</table>