<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>
<?php
if ($_POST[step]=="2")
{
    $x="";
    if ($_POST['semester_id']<>"")
    {
        $x.=" and a.semester_id='".$_POST['semester_id']."'";
    }
	if ($_POST['course_id']<>"")
    {
        $x.=" and b.course_id='".$_POST['course_id']."'";
    }
	if ($_POST['teacher_id']<>"")
    {
        $x.=" and b.teacher_id='".$_POST['teacher_id']."'";
    }
    if ($_POST['course_category_id']<>"")
    {
        $x.=" and d.category_id='".$_POST['course_category_id']."'";
    }
    ?>
    <table class="tableslistr" width="100%" border="1">
        <tr class="tablesheader">
            <td>ردیف</td>
            <td>نام و نام خانوادگی</td>
            <td>شماره تماس</td>
            <td>شماره موبایل</td>
            <td>ترم</td>
            <td>نام دوره</td>
            <td>گروه دوره</td>
            <td>نام استاد</td>
            <td>وضعیت دوره</td>
        </tr>
        <?php
        $db->query("select 
		c.id as student_id,
		concat(c.firstname,' ',c.lastname) as student_fullname,
		c.tel as student_tel,
		c.mobile as student_mobile,
		c.inactive as student_inactive,
		b.inactive as student_course_inactive,
		g.title as semester_title,
		d.title as course_title,
		e.title as course_category_title,
		concat(f.firstname,' ',f.lastname) as teacher_fullname
		from 
		students_courses_registrations a,students_courses b,students c,courses d,courses_categories e,teachers f,semesters g
		where a.student_course_id=b.id and c.id=b.student_id and b.course_id=d.id and e.id=d.category_id and f.id=b.teacher_id and a.semester_id=g.id
		$x
		order by 2
		");
        $res=$db->result();
        $i=1;
        $data="";
        foreach ($res as $row)
        {
			$bgcolor="";
			if ($row['student_inactive']=="1")
			{
				$bgcolor="#33ccff";
			}
            ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
                <td><?php echo $i++; ?></td>
                <td><a href="index.php?pid=students&student_id=<?php echo $row['student_id']; ?>&func=courses" target="_blank"><?php echo $row['student_fullname']; ?> (<?php echo $row['student_id']; ?>)</a></td>
                <td><?php echo $row['student_tel']; ?></td>
                <td><?php echo $row['student_mobile']; ?></td>
                <td><?php echo $row['semester_title']; ?></td>
                <td><?php echo $row['course_title']; ?></td>
                <td><?php echo $row['course_category_title']; ?></td>
                <td><?php echo $row['teacher_fullname']; ?></td>
                <td>
					<?php
					if ($row['student_course_inactive']=="1")
						echo "غیرفعال";
					else
						echo "فعال";
					?>
				</td>
            </tr>
            <?php
        }
        ?>
    </table>
    

    <?php   
    
}
else
{
?>
    <form method="post">
    <input type="hidden" name="step" value="2">
    <table class="tables" width="50%">
        <tr>
            <td align="left"><b>ترم:</b></td>
            <td>
                <select name="semester_id">
                    <option value="">--انتخاب کنید--</option>
					<?php
						$db->query("select * from semesters");
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
        </tr>
		<tr>
            <td align="left"><b>نام دوره:</b></td>
            <td>
                <select name="course_id">
                    <option value="">--انتخاب کنید--</option>
					<?php
						$db->query("select * from courses");
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
        </tr>
		<tr>
            <td align="left"><b>نام استاد:</b></td>
            <td>
                <select name="teacher_id">
                    <option value="">--انتخاب کنید--</option>
					<?php
						$db->query("select * from teachers order by firstname,lastname");
						$res=$db->result();
						foreach ($res as $row)
						{
							?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['firstname']." ".$row['lastname']; ?></option>
							<?php
						}
					?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="left"><b>گروه دوره:</b></td>
            <td>
                <select name="course_category_id">
                    <option value="">--انتخاب کنید--</option>
					<?php
						$db->query("select * from courses_categories");
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
        </tr>
		
		<tr><td colspan="2" align="center"><button type="submit">جستجو</button></td></tr>
    </table>
<?php    
}
?>


