<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<a href="index.php?pid=courses&course_id=<?php echo $course_id; ?>&func=students&func2=send_to_moodle">
ارسال به مودل</a>
<table class="tableslistr" border="1">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام و نام خانوادگی</td>
		<td>درصد تخفیف</td>
		<td>حذف</td>
	</tr>
	<?php
	$db->query("select * from courses_students where course_id='".$course_id."'");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{
		$db->query("select * from students where id='".$row['student_id']."'");
		$res2=$db->result();
		$row2=$res2[0];
		$fullname=$row2['firstname']." ".$row2['lastname'];
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $fullname; ?></td>
			<td><?php echo $row['discount_rate']; ?></td>
			<td>حذف</td>
		</tr>
		<?php
	}
?>
</table>