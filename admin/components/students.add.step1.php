<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<form method="POST" enctype="multipart/form-data">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="80%">
		<tr class="tablesheader"><td valign="top" colspan="4">اضافه کردن دانشجوی جدید</td></tr>
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
		<tr class="odd">
			<td valign="top" align="left"><b>ایمیل:</b></td>
			<td valign="top"><input type="text" name="email" value="<?php echo $_POST['email']; ?>" size="20" id="email"></td>
			<td valign="top" align="left"><b>تاریخ تولد:</b></td>
			<td valign="top"><input type="text" name="birth_date" value="<?php echo $_POST['birth_date']; ?>" dir="ltr"><?php calendar("birth_date"); ?></td>			
		</tr>
		<tr>
			<td valign="top" align="left"><b>شغل:</b></td>
			<td valign="top"><input type="text" name="job" value="<?php echo $_POST['job']; ?>" size="20" id="job"></td>
			<td valign="top" align="left"><b>تحصیلات:</b></td>
			<td valign="top"><input type="text" name="education" value="<?php echo $_POST['education']; ?>" size="20" id="education"></td>
		</tr>
		<tr class="odd">
			<td valign="top" align="left"><b>آدرس:</b></td>
			<td valign="top"><textarea  rows="3" name="address" cols="30" id="address"><?php echo $_POST[address]; ?></textarea></td>
			<td valign="top" align="left"><b>سابقه فناوری اطلاعات:</b></td>
			<td valign="top"><textarea  rows="3" name="IT_history" cols="30" id="IT_history"><?php echo $_POST['IT_history']; ?></textarea></td>			
		</tr>
		<tr>
			<td valign="top" align="left"><b>تاریخ ثبت اشتراک *:</b></td>
			<td valign="top"><input type="text" name="reg_date" size="20" readonly="true" value="<?php echo $today; ?>" dir="ltr"><?php calendar("reg_date"); ?></td>
			<td valign="top" align="left"><b>عکس:</b></td>
			<td valign="top"><input type="file" name="image" id="image"></td>
		</tr>
		
		
		<tr>
			<td valign="top" colspan="4"  align="center"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>