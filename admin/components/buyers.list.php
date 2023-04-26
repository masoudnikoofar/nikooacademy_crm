<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<a href="index.php?pid=buyers&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن خریداری جدید</a><br />
<form method="POST">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="80%">
		<tr class="tablesheader">
			<td colspan="4">جستجوی خریدار</td>
		</tr>
		<tr>
			<td align="left"><b>نام:</b></td>
			<td><input type="text" name="firstname" size="20"></td>
			<td align="left"><b>نام خانوادگی:</b></td>
			<td><input type="text" name="lastname" size="20"></td>
		</tr>
		<tr class="odd">
			<td align="left"><b>تلفن:</b></td>
			<td><input type="text" name="tel" size="20"></td>
			<td align="left"><b>تلفن همراه:</b></td>
			<td><input type="text" name="mobile" size="20"></td>
		</tr>
		<tr>
			<td colspan="4"  align="center"><button type="submit">جستجو</button></td>
		</tr>
	</table>
</form>
<?php
include("buyers.list.step2.php");  
?>  