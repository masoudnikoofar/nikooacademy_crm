<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$person_id=$db->mysql_real_escape_string($_GET['person_id']);
if ($_POST[step]=="2")
{
	$db->query("insert into people_rollcall set
	person_id='".$person_id."',
	date='".$_POST['date']."',
	enter_time='".$_POST['enter_time']."',
	exit_time='".$_POST['exit_time']."'
	");
	alert("با موفقیت ثبت شد");
}
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables" >
	<tr><td colspan="2" class="tablesheader">ورود ساعت حضور غیاب</td></tr>
	<tr>
		<td align="left"><b>تاریخ:</b></td>
		<td><input type="text" name="date"><?php calendar("date"); ?></td>
	</tr>
	<tr>
		<td align="left"><b>ساعت ورود:</b></td>
		<td><input type="text" name="enter_time">(hh24:mm:ss)</td>
	</tr>
	<tr>
		<td align="left"><b>ساعت خروج:</b></td>
		<td><input type="text" name="exit_time">(hh24:mm:ss)</td>
	</tr>
	
	<tr><td colspan="2" align="center"><button type="submit">اضافه</button></td></tr>
</table>
</form>