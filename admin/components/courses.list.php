<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<table class="tables">
	<tr>
		<td align="center">
			<a href="index.php?pid=courses&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن درس جدید</a> 
		</td>
		<td align="center">
			<a href="index.php?pid=courses_categories"><img src="../images/buttons/courses_categories.png" border="0"><br/>گروه های دروس</a> 
		</td>
	</tr>
</table>

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
		<td align="left"><b>وضعیت:</b></td>
		<td>
			<input type="radio" name="course_status" value="1" checked="checked"> فعال
			<input type="radio" name="course_status" value="0"> غیرفعال
		</td>
		<td><button type="submit">جستجو</button></td>
	</tr>
	
</table>
</form>

<?php
include("components/courses.list.step2.php");
?>
