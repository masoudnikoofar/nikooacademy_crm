<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$db->query("select x.*,x.transaction_type+0 as transaction_type_id from goods_log x where good_id='".$good_id."' order by invoice_date, id desc");
$res=$db->result();
$i=1;
?>
<table class="tableslistr" border="1" width="100%">
	<tr class="tablesheader">
		<td colspan="11">سابقه کالا</td>
	</tr>
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نوع تراکنش</td>
		<td>تعداد</td>
		<td>قیمت خرید تک</td>
		<td>قیمت فروش تک</td>
		<td>سود فروش تک</td>
		<td>تاریخ فاکتور</td>
		<td>شماره فاکتور خرید</td>
		<td>کد دانشجو (شماره فاکتور)</td>
		<td>توضیحات</td>
		<td>حذف</td>
	</tr>
	<?php
	foreach ($res as $row)
	{
		$good_log_id=$row['id'];
		$invoice_date=$row['invoice_date'];
		$transaction_type=$row['transaction_type'];
		$number=$row['number'];
		$price_one_buy=$row['price_one_buy'];
		$price_one_sell=$row['price_one_sell'];		
		$interest_one_sell=$price_one_sell-$price_one_buy;
		$invoice_no_buy=$row['invoice_no_buy'];
		$buyer_id=$row['buyer_id'];
		$buyer_invoice_id=$row['buyer_invoice_id'];
		$comment=$row['comment'];
	?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $transaction_type; ?></td>
			<td>
				<?php
				echo $number;
				if ($number>0) 
				{
					?>
					<img src="../images/buttons/up.png">
					<?php
				}
				else if ($number<0)
				{
					?>
					<img src="../images/buttons/down.png">
					<?php
				}
				?>
			</td>
			<td><?php echo $price_one_buy; ?></td>
			<td><?php echo $price_one_sell; ?></td>
			<td><?php echo $interest_one_sell; ?></td>
			<td><?php echo $invoice_date; ?></td>
			<td><?php echo $invoice_no_buy; ?></td>
			<td>
				<?php
				if ($buyer_id>0)
					echo $buyer_id;
				if ($buyer_invoice_id>0)
					echo "(".$buyer_invoice_id.")";
				?>
			</td>
			<td><?php echo $comment; ?></td>
			<td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=goods&good_id=<?php echo $good_id; ?>&func=log&func2=delete&good_log_id=<?php echo $good_log_id; ?>')"><img src="../images/buttons/delete2.png" border="0"></a></td>
		</tr>
	<?php
	}
	?>
</table>