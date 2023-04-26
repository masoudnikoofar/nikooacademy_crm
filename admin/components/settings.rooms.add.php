<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    $db->query("insert into rooms set 
    title='".$_POST['title']."'
    ");
    alert("با موفقیت ثبت شد");
}
?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables">
<tr><td colspan="2" class="tablesheader">اضافه کردن اتاق جدید</td></tr>
<tr><td align="left"><b>عنوان:</b></td><td><input type="text" name="title"></td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>