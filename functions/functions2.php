<?php
function good_log($arguments)
{
	global $db;
	
	$transaction_type=$arguments['transaction_type'];
	$invoice_date=$arguments['invoice_date'];
	$good_id=$arguments['good_id'];
	$number=$arguments['number'];
	$price_one_buy=$arguments['price_one_buy'];
	$price_one_sell=$arguments['price_one_sell'];
	$invoice_no_buy=$arguments['invoice_no_buy'];
	$buyer_id=$arguments['buyer_id'];
	$buyer_invoice_id=$arguments['buyer_invoice_id'];
	$comment=$arguments['comment'];
	
	$db->query("insert into goods_log set
		transaction_type='".$transaction_type."',
		invoice_date='".$invoice_date."',
		good_id='".$good_id."',
		number='".$number."',
		price_one_buy='".$price_one_buy."',
		price_one_sell='".$price_one_sell."',
		invoice_no_buy='".$invoice_no_buy."',
		buyer_id='".$buyer_id."',
		buyer_invoice_id='".$buyer_invoice_id."',
		comment='".$comment."'
	");
}
?>