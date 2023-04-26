<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
	$db->query("select * from invoices where id='".$invoice_id."'");
	$res=$db->result();
	
?>
<table class="tableslistr" width="100%" border="1">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>تاریخ</td>
		<td>نام کالا</td>
		<td>تعداد</td>
		<td>قیمت</td>
		<td>هدیه</td>
		<td>حذف</td>
	</tr>
	<?php
	$db->query("select * from invoices_goods where invoice_id='".$invoice_id."'");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td>
				<?php
				$db->query("select * from goods where id='".$row['good_id']."'");
				$res_tmp=$db->result();
				$row_tmp=$res_tmp[0];
				echo $row_tmp['name'];
				?>
			</td>
			<td><?php echo $row['number']; ?></td>
			<td><?php echo $row['price']; ?></td>
			<td>
				<?php
				if ($row['is_gift']=="1")
				{
					?>
					<a href="index.php?pid=buyers&buyer_id=<?php echo $buyer_id; ?>&func=invoices&func2=edit&invoice_id=<?php echo $invoice_id; ?>&func3=good.gift&buyer_good_id=<?php echo $row['id']; ?>&is_gift=0"><img src="../images/buttons/gift_ok.png" border="0"></a>	
					<?php
				}
				else
				{
					?>
					<a href="index.php?pid=buyers&buyer_id=<?php echo $buyer_id; ?>&func=invoices&func2=edit&invoice_id=<?php echo $invoice_id; ?>&func3=good.gift&buyer_good_id=<?php echo $row['id']; ?>&is_gift=1"><img src="../images/buttons/gift_nok.png" border="0"></a>	
					<?php
				}
				?>
			</td>
			<td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=buyers&buyer_id=<?php echo $buyer_id; ?>&func=invoices&func2=edit&invoice_id=<?php echo $invoice_id; ?>&func3=good.delete&buyer_good_id=<?php echo $row['id']; ?>')"><img src="../images/buttons/delete2.png" border="0"></a></td>
		</tr>
		<?php
	}
	?>
</table>