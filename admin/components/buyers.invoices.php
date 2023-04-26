<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<a href="index.php?pid=buyers&buyer_id=<?php echo $buyer_id; ?>&func=invoices&func2=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن فاکتور جدید</a><br />
<table class="tables" width="50%" border="1">
	<?php
	$db->query("select * from invoices where buyer_id='$buyer_id' and is_student=0");
	$res=$db->result();
	$i=0;
	foreach ($res as $row)
	{
	$i++;
	?>		
		<tr>
			<td align="center" width="40%">فاکتور شماره <?php echo $i; ?></td>
			<td align="center" width="20%"><a href="index.php?pid=buyers&buyer_id=<?php echo $buyer_id; ?>&func=invoices&func2=edit&invoice_id=<?php echo $row['id']; ?>">ویرایش</a></td>
			<td align="center" width="20%"><a href="index.php?pid=buyers&buyer_id=<?php echo $buyer_id; ?>&func=invoices&func2=print&invoice_id=<?php echo $row['id']; ?>">چاپ</a><br/></td>
		</tr>
	<?php
	}
	?>
</table>
