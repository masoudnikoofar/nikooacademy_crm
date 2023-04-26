<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$person_id=$db->mysql_real_escape_string($_GET['person_id']);
$rollcall_id=$db->mysql_real_escape_string($_GET['rollcall_id']);
if ($_POST[step]=="2")
{
	$db->query("update people_rollcall set
	date='".$_POST['date']."',
	enter_time='".$_POST['enter_time']."',
	exit_time='".$_POST['exit_time']."'
	where id='".$rollcall_id."'
	");
	alert("با موفقیت ویرایش شد");
}
$db->query("select * from people_rollcall where id='".$rollcall_id."'");
$res=$db->result();
$row=$res[0];
$date=$row['date'];
$enter_time=$row['enter_time'];
$exit_time=$row['exit_time'];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables" >
	<tr><td colspan="2" class="tablesheader">ویرایش ساعت حضور غیاب</td></tr>
	<tr>
		<td align="left"><b>تاریخ:</b></td>
		<td><input type="text" name="date" value="<?php echo $date; ?>"><?php calendar("date"); ?></td>
	</tr>
	<tr>
		<td align="left"><b>ساعت ورود:</b></td>
		<td><input type="text" name="enter_time" value="<?php echo $enter_time; ?>">(hh24:mm)</td>
	</tr>
	<tr>
		<td align="left"><b>ساعت خروج:</b></td>
		<td><input type="text" name="exit_time" value="<?php echo $exit_time; ?>">(hh24:mm)</td>
	</tr>
	
	<tr><td colspan="2" align="center"><button type="submit">ویرایش</button></td></tr>
</table>
</form>