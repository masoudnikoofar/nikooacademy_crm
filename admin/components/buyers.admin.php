<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['buyer_id']))
{
    $buyer_id=$db->mysql_real_escape_string($_GET['buyer_id']);
	$db->query("select * from buyers where id='".$buyer_id."'");
	$res=$db->result();
	$row=$res[0];
	?>
	<table class="tables" width="100%">
		<tr class="tablesheader">
			<td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
		</tr>
	</table>
	<?php
}


if ($func=="add")
{
	include("components/buyers.add.php");
}
else if ($func=="invoices")
{
	if (isset($_GET['invoice_id']))
	{
		$invoice_id=$db->mysql_real_escape_string($_GET['invoice_id']);
	}
	if (isset($_GET['buyer_good_id']))
	{
		$buyer_good_id=$db->mysql_real_escape_string($_GET['buyer_good_id']);
	}
	if ($func2=="add")
	{
		$popup_arguments=array(
			"pid"=>"buyers.invoices.add&buyer_id=".$buyer_id,
			"parent_redirect"=>true,
			"parent_redirect_url"=>"index.php?pid=buyers&buyer_id=".$buyer_id."&func=invoices"
		);
		popup($popup_arguments);
	}
	else if ($func2=="edit")
	{
		
		if ($func3=="good.gift")
		{
			$is_gift=$_GET['is_gift'];
			$db->query("update invoices_goods set is_gift='".$is_gift."' where id='".$buyer_good_id."'");
		}
		else if ($func3=="good.delete")
		{
			//edit log of goods
			$db->query("select * from invoices_goods where id='".$buyer_good_id."'");
			$res=$db->result();
			$row=$res[0];
			$good_id=$row['good_id'];
			$good_number=$row['number'];
			$good_price=$row['price'];
			$buyer_id=$row['buyer_id'];
			$invoice_id=$row['invoice_id'];
			
			$good_log_args=array(
			"transaction_type"=>5,
			"invoice_date"=>$today,
			"good_id"=>$good_id,
			"number"=>$good_number,
			//"price_one_buy"=>$price_one_buy,
			"price_one_sell"=>$good_price,
			//"invoice_no_buy"=>$invoice_no_buy,
			"buyer_id"=>$buyer_id,
			"buyer_invoice_id"=>$invoice_id
			//"comment"=>$comment
		);
		good_log($good_log_args);

			//+++++++++++++++
			
			$db->query("update goods set number=number+".$good_number." where id='".$good_id."'");
			$db->query("delete from invoices_goods where id='".$buyer_good_id."'");
			
			
			
			alert("با موفقیت حذف شد");
		}
		//popup(array("pid"=>"buyers.invoices.edit&buyer_id=".$buyer_id."&invoice_id=".$invoice_id));
		include("components/buyers.invoices.edit.php");
	}
	else if ($func2=="print")
	{
		$popup_arguments=array(
			"pid"=>"buyers.invoices.print&buyer_id=".$buyer_id."&invoice_id=".$invoice_id,
			"parent_redirect"=>true,
			"parent_redirect_url"=>"index.php?pid=buyers&buyer_id=".$buyer_id."&func=invoices",
			"width"=>800,
			"heigth"=>600
		);
		popup($popup_arguments);
	}
	else
		include("components/buyers.invoices.php");
}
else
{
	include("components/buyers.list.php");
}
?>