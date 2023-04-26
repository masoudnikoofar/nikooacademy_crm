<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST['step']=="2")
{	
	$db->query("select * from courses");
	$res=$db->result();
	foreach ($res as $row)
	{
		if ($_POST['course_id_'.$row['id']]=="on")
		{
			$db->query("delete from teachers_courses where
				teacher_id='".$teacher_id."' and course_id='".$row['id']."'");
			$db->query("insert into teachers_courses set 
				teacher_id='".$teacher_id."',
				course_id='".$row['id']."'");
		}
		else
		{
			$db->query("delete from teachers_courses where
				teacher_id='".$teacher_id."' and course_id='".$row['id']."'");
		}
	}
	alert("با موفقیت ثبت شد");
}		
?>	
<form method="post">
	<table class="tables" width="100%" border="1">
		<tr class="tablesheader">
			<td colspan="2">
				<?php
				$db->query("select * from teachers where id='".$teacher_id."'");
				$res=$db->result();
				$row=$res[0];
				echo $row['firstname']." ".$row['lastname'];
				?>
			</td>
		</tr>
		<tr class="tablesheader">
			<td>گروه دوره</td>
			<td>نام دوره</td>
		</tr>
		<input type="hidden" name="step" value="2">
		<?php
		$db->query("select * from courses_categories");
		$res_tmp1=$db->result();
		foreach ($res_tmp1 as $row_tmp1)
		{
			?>
			<tr>
				<td><?php echo $row_tmp1['title']; ?></td>
				<td>
					<?php
					$db->query("select * from courses where category_id='".$row_tmp1['id']."'");
					$res_tmp2=$db->result();
					foreach ($res_tmp2 as $row_tmp2)
					{
						$db->query("select id from teachers_courses where teacher_id='".$teacher_id."' and course_id='".$row_tmp2['id']."'");
						$res_tmp3=$db->result();
						if (count($res_tmp3)>0)
							$checked="checked";
						else
							$checked="";
						?>
						<input type="checkbox" name="course_id_<?php echo $row_tmp2['id']; ?>" <?php echo $checked; ?>> <?php echo $row_tmp2['title']; ?>
						<?php
					}
					?>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
	<br/>
	<button type="submit">ثبت</button>
</form>