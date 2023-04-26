<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    $db->query("insert into people set name='".$_POST[name]."',mobile='".$_POST[mobile]."'");
    alert("با موفقیت ثبت شد");
}
?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables">
<tr><td colspan="2" class="tablesheader">اضافه کردن پرسنل جدید</td></tr>
<tr><td align="left"><b>نام:</b></td><td><input type="text" name="name"></td></tr>
<tr><td align="left"><b>شماره موبایل:</b></td><td><input type="text" name="mobile"></td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>