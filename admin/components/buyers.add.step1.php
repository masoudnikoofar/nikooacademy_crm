<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<form method="POST">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="80%">
		<tr class="tablesheader"><td valign="top" colspan="4">اضافه کردن خریدار جدید</td></tr>
		<tr class="odd">
			<td valign="top" align="left"><b>نام *:</b></td>
			<td valign="top"><input type="text" name="firstname" value="<?php echo $_POST[firstname]; ?>" size="20"></td>
			<td valign="top" align="left"><b>نام خانوادگی *:</b></td>
			<td valign="top"><input type="text" name="lastname" value="<?php echo $_POST[lastname]; ?>" size="20" id="lname"></td>
		</tr>
		<tr>
			<td valign="top" align="left"><b>تلفن:</b></td>
			<td valign="top"><input type="text" name="tel" value="<?php echo $_POST[tel]; ?>" size="20" id="tel"></td>
			<td valign="top" align="left"><b>تلفن همراه:</b></td>
			<td valign="top"><input type="text" name="mobile" value="<?php echo $_POST[mobile]; ?>" size="20"></td>
		</tr>
		<tr>
			<td valign="top" colspan="4"  align="center"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>