<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    $db->query("update people set name='".$_POST[name]."',mobile='".$_POST[mobile]."',status='".$_POST['status']."' where id='$person_id'");
    alert("با موفقیت ویرایش شد");
    goback("index.php?pid=people");
}
$db->query("select * from people where id='$person_id'");
$res=$db->result();
$row=$res[0];
?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="step" value="2">
<table width="60%" class="tables">
<tr><td colspan="2" class="tablesheader">اضافه کردن نصاب جدید</td></tr>
<tr><td align="left"><b>نام:</b></td><td><input type="text" name="name" value="<?php echo $row[name]; ?>"></td></tr>
<tr><td align="left"><b>شماره موبایل:</b></td><td><input type="text" name="mobile" value="<?php echo $row[mobile]; ?>"></td></tr>
<tr>
    <td align="left"><b>وضعیت:</b></td>
    <td>
        <input type="radio" name="status" value="0" <?php if ($row['status']=="0") echo "checked"; ?>>فعال</option>
        <input type="radio" name="status" value="1" <?php if ($row['status']=="1") echo "checked"; ?>>غیرفعال</option>
    </td>
</tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>