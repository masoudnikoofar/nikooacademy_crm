<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&func2=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن دوره جدید</a><br />
<table class="tableslistr" border="1">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
<!--		<td>تاریخ ثبت نام اولیه</td> -->
		<td>اطلاعات ثبت نام</td>
		<td>سهم استاد</td>
		<td>وضعیت</td>
		<td>ویرایش</td>
		<td>حذف</td>
	</tr>
	<?php
	$db->query("select * from students_courses where student_id='".$student_id."'");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td>
				<?php
				$db->query("select * from courses where id='".$row['course_id']."'");
				$res_tmp=$db->result();
				$row_tmp=$res_tmp[0];
				echo $row_tmp['title'];
				?>
			</td>
			<td>
				<?php
				$db->query("select * from teachers where id='".$row['teacher_id']."'");
				$res_tmp=$db->result();
				$row_tmp=$res_tmp[0];
				echo $row_tmp['firstname']." ".$row_tmp['lastname'];
				?>
			</td>
			<!--<td><?php echo $row['reg_date']; ?></td>-->
			<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=registrations.list"><img src="../images/buttons/register.png" border="0"></a></td>
			
			<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=teachers_share"><img src="../images/buttons/teachers_share.png" border="0"></a></td>
			<?php
			if ($row['inactive']=="1")
			{
				?>
				<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=status&inactive=0"><img src="../images/buttons/students_courses_inactive.png" border="0"></a></td>
				<?php
			}
			else
			{
				?>
				<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=status&inactive=1"><img src="../images/buttons/students_courses_active.png" border="0"></a></td>
				<?php
			}
			?>
			
			
			<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
			<td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&student_course_id=<?php echo $row['id']; ?>&func2=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
		</tr>
		<?php
	}
	?>
</table>