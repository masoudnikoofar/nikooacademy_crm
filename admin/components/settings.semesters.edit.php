<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    $db->query("update semesters set 
    title='".$_POST['title']."',
    start_date='".$_POST['start_date']."',
    finish_date='".$_POST['finish_date']."'
    where id='$semester_id'");
    alert("با موفقیت ویرایش شد");
}
$db->query("select * from semesters where id='$semester_id'");
$res=$db->result();
$row=$res[0];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="60%" class="tables">
<tr><td colspan="2" class="tablesheader">ویرایش ترم</td></tr>
<tr><td align="left"><b>عنوان:</b></td><td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td></tr>
<tr><td align="left"><b>تاریخ شروع:</b></td><td><input type="text" name="start_date" value="<?php echo $row['start_date']; ?>"><?php calendar("start_date"); ?></td></tr>
<tr><td align="left"><b>تاریخ پایان:</b></td><td><input type="text" name="finish_date" value="<?php echo $row['finish_date']; ?>"><?php calendar("finish_date"); ?></td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>