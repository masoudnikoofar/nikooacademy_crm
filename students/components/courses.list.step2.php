<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$x="1=1";
if ($_POST['category_id']!="")
{	
	$category_id=$db->mysql_real_escape_string($_POST['category_id']);
	$x.=" and category_id='".$category_id."'";
}
if ($_POST['course_status']!="")
{
	$course_status = $db->mysql_real_escape_string($_POST['course_status']);
	$x.=" and course_status='".$course_status."'";
}
else
{
	$x.=" and course_status='1'";
}
?>
<table class="tableslistr" border="1" width="80%">
	<tr class="tablesheader"><td>ردیف</td><td>نام درس</td><td>شهریه</td><td>درصد تخفیف</td><td>گروه</td><td>دانشجویان</td><td>زمانبندی</td><td>ارسال به مودل</td><td>ویرایش</td><td>حذف</td></tr>
	<?php
	$db->query("select * from courses a,courses_students b where a.id=b.course_id and b.student_id='".$student_id."' $x order by id desc");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{
		$course_status = $row['course_status'];
		if ($course_status == "1")
		{
			//$bgcolor = "#53A451";
		}
		else
		{
			$bgcolor = "bgcolor='#9F353B'";
		}
		?>
		<tr <?php echo $bgcolor; ?>>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo price_english($row['tuition_fee']); ?></td>
			<td><?php echo $row['discount_rate']; ?></td>
			<td>
				<?php 
				$db->query("select * from courses_categories where id='".$row['category_id']."'");
				$res2=$db->result();
				$row2=$res2[0];
				echo $row2['title'];
				?>
			</td>
			<td><a href="index.php?pid=courses&course_id=<?php echo $row['id']; ?>&func=students"><img src="../images/buttons/students.png" border="0"></a></td>
			<td><a href="index.php?pid=courses&course_id=<?php echo $row['id']; ?>&func=sessions"><img src="../images/buttons/schedule.png" border="0"></a></td>
			<td><a href="index.php?pid=courses&course_id=<?php echo $row['id']; ?>&func=send_to_moodle"><img src="../images/buttons/moodle.png" border="0"></a></td>
			<td><a href="index.php?pid=courses&course_id=<?php echo $row['id']; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
			<td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=courses&course_id=<?php echo $row['id']; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
		</tr>
		<?php   
	}
	?>
</table>