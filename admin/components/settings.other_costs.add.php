<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
	$title = $db->mysql_real_escape_string($_POST['title']);
	$date = $db->mysql_real_escape_string($_POST['date']);
	$amount = $db->mysql_real_escape_string($_POST['amount']);
	$person_id = $db->mysql_real_escape_string($_POST['person_id']);
    $db->query("insert into other_costs set 
		title='".$title."',
		date='".$date."',
		person_id='".$person_id."',
		amount='".$amount."'
    ");
    alert("با موفقیت ثبت شد");
}
?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="step" value="2">
<table width="100%" class="tables">
<tr><td colspan="2" class="tablesheader">اضافه کردن هزینه جدید</td></tr>
<tr><td align="left"><b>عنوان:</b></td><td><input type="text" name="title"></td></tr>
<tr><td align="left"><b>تاریخ:</b></td><td><input type="text" name="date"><?php calendar("date"); ?></td></tr>
<tr><td align="left"><b>مبلغ:</b></td><td><input type="text" name="amount"></td></tr>
<tr>
	<td align="left"><b>شخص:</b></td>
	<td>
		<select name="person_id">
			<option value="">--انتخاب کنید--</option>
			<?php
			$db->query("select * from users");
			$res = $db->result();
			foreach ($res as $row)
			{
				?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['fullname']; ?></option>
				<?php
			}
			?>
		</select>
	</td>
</tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>