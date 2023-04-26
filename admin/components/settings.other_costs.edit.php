<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    $db->query("update other_costs set 
    title='".$_POST['title']."',
    date='".$_POST['date']."',
    amount='".$_POST['amount']."'
    where id='$other_cost_id'");
    alert("با موفقیت ویرایش شد");
}
$db->query("select * from other_costs where id='$other_cost_id'");
$res=$db->result();
$row=$res[0];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="60%" class="tables">
<tr><td colspan="2" class="tablesheader">ویرایش اتاق</td></tr>
<tr><td align="left"><b>عنوان:</b></td><td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td></tr>

<tr><td align="left"><b>تاریخ:</b></td><td><input type="text" name="date" value="<?php echo $row['date']; ?>"><?php calendar("date"); ?></td></tr>
<tr><td align="left"><b>مبلغ:</b></td><td><input type="text" name="amount" value="<?php echo $row['amount']; ?>"></td></tr>

</td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>