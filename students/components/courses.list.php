<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<form method="post">
<table class="tables" width="80%">
	<tr class="tablesheader">
		<td colspan="5">جستجوی درس</td>
	</tr>
	<tr>
		<td align="left"><b>گروه:</b></td>
		<td>
			<select name="category_id" id="category_id">
				<option value="">--انتخاب کنید--</option>
				<?php
				$db->query("select * from courses_categories where parent_id=0 order by title");
				$res=$db->result();
				foreach ($res as $row)
				{
					?>
					<option value="">------------------</option>
					<?php
					$db->query("select * from courses_categories where parent_id='".$row['id']."' order by title");
					$res2=$db->result();
					foreach ($res2 as $row2)
					{
						?>
						<option value="<?php echo $row2['id']; ?>"><?php echo $row['title']; ?> --> <?php echo $row2['title']; ?></option>
						<?php
					}
				}
				?>
			</select>
		</td>
		<td><button type="submit">جستجو</button></td>
	</tr>
	
</table>
</form>

<?php
include("components/courses.list.step2.php");
?>
