<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$x="1=1 and parent_id=0";
if ($_POST['parent_id']!="")
{	
	$parent_id=$db->mysql_real_escape_string($_POST['parent_id']);
	$x.=" and id='".$parent_id."'";
}
?>
<table class="tableslistr" border="1" width="80%">
	<tr class="tablesheader"><td>ردیف</td><td>شناسه مودل</td><td>نام گروه</td><td>گروه پدر</td><td>ارسال به مودل</td><td>ویرایش</td><td>حذف</td></tr>
	<?php
	$db->query("select * from courses_categories where $x");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr class="tablesheader">
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['moodle_category_id']; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td></td>
			<td><a href="index.php?pid=courses_categories&course_category_id=<?php echo $row['id']; ?>&func=send_to_moodle"><img src="../images/buttons/moodle.png" border="0"></a></td>
			<td><a href="index.php?pid=courses_categories&course_category_id=<?php echo $row['id']; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
			<td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=courses_categories&course_category_id=<?php echo $row['id']; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
		</tr>
		<?php
		$db->query("select * from courses_categories where parent_id='".$row['id']."'");
		$res2=$db->result();
		foreach ($res2 as $row2)
		{
			?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $row2['moodle_category_id']; ?></td>
				<td><?php echo $row2['title']; ?></td>
				<td><?php echo $row['title']; ?></td>
				<td><a href="index.php?pid=courses_categories&course_category_id=<?php echo $row2['id']; ?>&func=send_to_moodle"><img src="../images/buttons/moodle.png" border="0"></a></td>
				<td><a href="index.php?pid=courses_categories&course_category_id=<?php echo $row2['id']; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
				<td><a href='#' onclick="confirm_delete('<?php echo $row2['id']; ?>','index.php?pid=courses_categories&course_category_id=<?php echo $row2['id']; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
			</tr>
			<?php   
		}
	}
	?>
</table>