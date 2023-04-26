<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    $db->query("update rooms set 
    title='".$_POST['title']."'
    where id='$room_id'");
    alert("با موفقیت ویرایش شد");
}
$db->query("select * from rooms where id='$room_id'");
$res=$db->result();
$row=$res[0];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="60%" class="tables">
<tr><td colspan="2" class="tablesheader">ویرایش اتاق</td></tr>
<tr><td align="left"><b>عنوان:</b></td><td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td></tr>
</td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>