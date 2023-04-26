<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<table class="tableslistr" border="1">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>نام دوره</td>
		<td>نام استاد</td>
		<td>تاریخ شروع کلاس</td>
		<td>اطلاعات پرداخت</td>
		<td>گواهی</td>
		<td>وضعیت</td>
		<td>حذف</td>
	</tr>
	<?php
	$db->query("select * from courses_students where student_id='".$student_id."'");
	$res=$db->result();
	$i=1;
	foreach ($res as $row)
	{
		$db->query("select * from courses where id='".$row['course_id']."'");
		$res_tmp=$db->result();
		$row_tmp=$res_tmp[0];
		$course_title = $row_tmp['title'];
		$course_teacher_id = $row_tmp['teacher_id'];
		$course_start_date = $row_tmp['start_date'];
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $course_title; ?></td>
			<td>
				<?php
				$db->query("select * from teachers where id='".$course_teacher_id."'");
				$res_tmp=$db->result();
				$row_tmp=$res_tmp[0];
				echo $row_tmp['firstname']." ".$row_tmp['lastname'];
				?>
			</td>
			<td><?php echo $course_start_date; ?></td>
			<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&course_student_id=<?php echo $row['id']; ?>&func2=payments"><img src="../images/buttons/register.png" border="0"></a></td>
			<td>
			<?php
			$db->query("select * from certificates where course_id='".$row['course_id']."' and student_id='".$student_id."'");
			$res_tmp = $db->result();
			if (count($res_tmp)>0)
			{
				$row_tmp = $res_tmp[0];
				?>
				<a href="<?php echo CERTIFICATE_EN_URL.$row_tmp['uid']; ?>"><img src="../images/buttons/certificate.png" border="0"></a>
				<?php
			}
			else
			{

			}
			?>
			</td>
			
			<?php
			if ($row['inactive']=="1")
			{
				?>
				<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&course_student_id=<?php echo $row['id']; ?>&func2=status&inactive=0"><img src="../images/buttons/students_courses_inactive.png" border="0"></a></td>
				<?php
			}
			else
			{
				?>
				<td><a href="index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&course_student_id=<?php echo $row['id']; ?>&func2=status&inactive=1"><img src="../images/buttons/students_courses_active.png" border="0"></a></td>
				<?php
			}
			?>
			
			
			<td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=students&student_id=<?php echo $student_id; ?>&func=courses&course_student_id=<?php echo $row['id']; ?>&func2=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
		</tr>
		<?php
	}
	?>
</table>