<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<table class="tables">
	<tr>
		<td align="center">
			<a href="index.php?pid=courses_categories&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن گروه جدید</a> 
		</td>
	</tr>
</table>

<form method="post">
<table class="tables" width="80%">
	<tr class="tablesheader">
		<td colspan="3">جستجوی گروه</td>
	</tr>
	<tr>
		<td align="left"><b>گروه:</b></td>
		<td>
			<select name="parent_id" id="parent_id">
				<option value="">--انتخاب کنید--</option>
				<?php
				$db->query("select * from courses_categories where parent_id=0 order by title");
				$res=$db->result();
				foreach ($res as $row)
				{
					?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
					<?php
				}
				?>
			</select>
		</td>
		<td><button type="submit">جستجو</button></td>
	</tr>
	
</table>
</form>

<?php
include("components/courses_categories.list.step2.php");
?>
