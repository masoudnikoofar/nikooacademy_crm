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
			<td>ترم</td>
			<td>نام دانشجو</td>
			<td>نام استاد</td>
			<td>عنوان دوره</td>
			<td>مبلغ پرداختی</td>
			<td>تعداد جلسات</td>
        </tr>
        <?php
        $db->query("select 
		d.title as semester_title,
		g.id as student_id,
		concat(g.firstname,' ',g.lastname) as student_fullname,
		concat(f.firstname,' ',f.lastname) as teacher_fullname,
		e.title as course_title,
		b.payment_amount,
		b.session_numbers
		from 
		students_courses_registrations a,students_courses_registrations_payments b,students_courses c,semesters d,courses e,teachers f,students g
		where 
		a.id=b.student_course_registration_id
		and a.student_course_id=c.id
		and a.semester_id=d.id
		and c.course_id=e.id
		and c.teacher_id=f.id
		and c.student_id=g.id
		$x");
        $res=$db->result();
        $i=1;
        $data="";
		$sum_payment_amount=0;
        foreach ($res as $row)
        {	
			$sum_payment_amount+=$row['payment_amount'];
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['semester_title']; ?></td>
                <td><a href="index.php?pid=students&student_id=<?php echo $row['student_id']; ?>&func=courses" target="_blank"><?php echo $row['student_fullname']; ?> (<?php echo $row['student_id']; ?>)</a></td>
                <td><?php echo $row['teacher_fullname']; ?></td>
                <td><?php echo $row['course_title']; ?></td>
                <td><?php echo price_english($row['payment_amount']); ?></td>
                <td><?php echo $row['session_numbers']; ?></td>
            </tr>
            <?php
        }
        ?>
		<tr class="tablesheader">
			<td colspan="6">جمع کل</td>
			<td><?php echo price_english($sum_payment_amount); ?></td>
		</tr>
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


