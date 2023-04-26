<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['other_cost_id']))
{
    $other_cost_id=$_GET['other_cost_id'];
}
if ($_GET['func']=="add")
{
	$popup_arguments=array("pid"=>"settings.other_costs.add");
    popup($popup_arguments);
}
else if ($_GET['func']=="edit")
{
    include("components/settings.other_costs.edit.php");
}
else if ($_GET['func']=="delete")
{
    $db->query("delete from other_costs where id='$other_cost_id'");
    alert("با موفقیت حذف شد");
    goback("index.php?pid=other_costs");
}
else
{
    ?>
    <a href="index.php?pid=settings.other_costs&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن هزینه</a>
    <br />
    <table class="tableslistr" border="1" width="50%">
        <tr class="tablesheader">
			<td>ردیف</td>
            <td>عنوان هزینه</td>
            <td>شخص</td>
			<td>تاریخ</td>
			<td>مبلغ</td>
			<td>ویرایش</td>
			<td>حذف</td>
		</tr>
    <?php
    $db->query("select * from other_costs order by id desc");
    $res=$db->result();
    $i=1;
	$total_amount = 0;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td>
				<?php
				$db->query("select * from users where id='".$row['person_id']."'");
				$res_tmp = $db->result();
				$row_tmp = $res_tmp[0];
				echo $row_tmp["fullname"];
				?>
			</td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo price_english($row['amount']); ?></td>
            <td><a href="index.php?pid=settings.other_costs&other_cost_id=<?php echo $row[id]; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
            <td><a href='#' onclick="confirm_delete('<?php echo $row[id]; ?>','index.php?pid=settings.other_costs&other_cost_id=<?php echo $row[id]; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
        </tr>
        <?php 
		$total_amount += $row['amount'];
    }
	?>
        <tr class="tablesheader">
            <td colspan="4">جمع کل</td>
            <td colspan="3"><?php echo price_english($total_amount); ?></td>
		</tr>
	</table>
<?php
}
?>