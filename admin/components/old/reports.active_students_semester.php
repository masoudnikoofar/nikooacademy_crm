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
	?>
    <table class="tableslistr" width="100%" border="1">
        <tr class="tablesheader">
            <td>ردیف</td>
            <td>نام و نام خانوادگی</td>
            <td>شماره تماس</td>
            <td>شماره موبایل</td>
        </tr>
        <?php
        $db->query("select distinct
		c.id as student_id,
		concat(c.firstname,' ',c.lastname) as student_fullname,
		c.tel as student_tel,
		c.mobile as student_mobile
		from 
		students_courses_registrations a,students_courses b,students c,courses d,courses_categories e,teachers f,semesters g
		where a.student_course_id=b.id and c.id=b.student_id and b.course_id=d.id and e.id=d.category_id and f.id=b.teacher_id and a.semester_id=g.id
		and c.inactive=0
		$x
		order by 1
		");
        $res=$db->result();
        $i=1;
        $data="";
        foreach ($res as $row)
        {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><a href="index.php?pid=students&student_id=<?php echo $row['student_id']; ?>&func=courses" target="_blank"><?php echo $row['student_fullname']; ?> (<?php echo $row['student_id']; ?>)</a></td>
                <td><?php echo $row['student_tel']; ?></td>
                <td><?php echo $row['student_mobile']; ?></td>
            </tr>
            <?php
        }
        ?>
        <tr class="tablesheader">
            <td colspan="4">لیست دانشجوهای فعالی که در این ترم ثبت نام نکرده اند</td>
        </tr>
        <tr class="tablesheader">
            <td>ردیف</td>
            <td>نام و نام خانوادگی</td>
            <td>شماره تماس</td>
            <td>شماره موبایل</td>
        </tr>
        <?php
        $db->query("
		select 
		concat(firstname,' ',lastname) as student_fullname,
		tel as student_tel,
		mobile as student_mobile
		from students where id not in (
		select b.student_id
		from 
		students_courses_registrations a,students_courses b,students c,semesters g
		where a.student_course_id=b.id and c.id=b.student_id and a.semester_id=g.id
		and c.inactive=0
		$x
		)
		and inactive=0
		");
        $res=$db->result();
        $i=1;
        $data="";
        foreach ($res as $row)
        {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['student_fullname']; ?></td>
                <td><?php echo $row['student_tel']; ?></td>
                <td><?php echo $row['student_mobile']; ?></td>
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
		<tr><td colspan="2" align="center"><button type="submit">جستجو</button></td></tr>
    </table>
<?php    
}
?>


