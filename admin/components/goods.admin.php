<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['good_id']))
{
    $good_id=$_GET['good_id'];
}
if (isset($_GET['func']))
{
    $func=$_GET['func'];
}
if (isset($_GET['func2']))
{
    $func2=$_GET['func2'];
}

if ($func=="add")
{
    $popup_arguments=array(
		"pid"=>"goods.add",
		"parent_redirect"=>true,
		"parent_redirect_url"=>"index.php?pid=goods",
		"width"=>300,
		"height"=>250
	);
	popup($popup_arguments);
}
else if ($func=="edit")
{
    include("components/goods.edit.php");
}
else if ($func=="delete")
{
    $db->query("delete from goods where id='$good_id'");
    alert("با موفقیت حذف شد");
    goback("index.php?pid=goods");
}
else if ($func=="log")
{
	if (isset($_GET['good_log_id']))
	{
		$good_log_id=$_GET['good_log_id'];
	}

	if ($func2=="delete")
    {
		$db->query("delete from goods_log where id='".$good_log_id."'");
		alert("با موفقیت حذف شد");
	}
}
else
{
    ?>
	<table class="tableslistr" width="100%">
		<tr>
			<td>
				<a href="index.php?pid=goods&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن کالای جدید</a>
			</td>
			<td>
				<a href="index.php?pid=buyers"><img src="../images/buttons/invoices.png" border="0"><br/>خریداران متفرقه</a>
			</td>
		</tr>
	</table>
    <br />
    <table class="tableslistr" border="1" width="50%">
		<tr class="tablesheader"><td colspan="8">لیست کالاهای جاری</td></tr>
        <tr class="tablesheader"><td>ردیف</td><td>نام کالا</td><td>سریال</td><td>تعداد</td><!--<td>قیمت خرید تک</td>--><td>قیمت فروش تک</td><td>ویرایش</td><td>حذف</td></tr>
    <?php
    $db->query("select * from goods where is_old=0 order by name");
    $res=$db->result();
    $i=1;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['serial_no']; ?></td>
            <td><?php echo $row['number']; ?></td>
            <!--<td><?php echo $row['price_one_buy']; ?></td>-->
            <td><?php echo $row['price_one_sell']; ?></td>
            <td><a href="index.php?pid=goods&good_id=<?php echo $row['id']; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
            <td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=goods&good_id=<?php echo $row['id']; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
        </tr>
        <?php   
    }
    ?>
	<br />
    <table class="tableslistr" border="1" width="50%">
		<tr class="tablesheader"><td colspan="8">لیست کالاهای قدیمی</td></tr>
        <tr class="tablesheader"><td>ردیف</td><td>نام کالا</td><td>سریال</td><td>تعداد</td><td>قیمت خرید تک</td><td>قیمت فروش تک</td><td>ویرایش</td><td>حذف</td></tr>
    <?php
    $db->query("select * from goods where is_old=1 order by name");
    $res=$db->result();
    $i=1;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['serial_no']; ?></td>
            <td><?php echo $row['number']; ?></td>
            <td><?php echo $row['price_one_buy']; ?></td>
            <td><?php echo $row['price_one_sell']; ?></td>
            <td><a href="index.php?pid=goods&good_id=<?php echo $row['id']; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
            <td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=goods&good_id=<?php echo $row['id']; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
        </tr>
        <?php   
    }
}
?>
</table>