<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['person_id']))
{
    $person_id=$_GET['person_id'];
}
if ($func=="add")
{
	$popup_arguments=array("pid"=>"settings.people.add");
    popup($popup_arguments);
}
else if ($func=="edit")
{
    include("components/settings.people.edit.php");
}
else if ($func=="rollcall")
{
	include("components/settings.people.rollcall.admin.php");
}
else if ($func=="base_wage")
{
	include("components/settings.people.base_wage.php");
}
else if ($func=="payments")
{
	include("components/settings.people.payments.admin.php");
}
else if ($func=="access")
{
    include("components/settings.people.access.php");
}
else if ($func=="delete")
{
    //$db->query("delete from people where id='$person_id'");
    //alert("با موفقیت حذف شد");
    //goback("index.php?pid=people");
	alert("در حال حاضر امکان حذف افراد وجود ندارد");
}
else
{
    ?>
    <a href="index.php?pid=settings.people&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن پرسنل جدید</a>
    <br />
    <table class="tableslistr" border="1" width="50%">
        <tr class="tablesheader">
			<td>ردیف</td>
			<td>نام</td>
			<td>موبایل</td>
			<td>وضعیت</td>
			<td>ویرایش</td>
			<td>دسترسی</td>
			<td>حضور غیاب</td>
			<td>پرداخت ها</td>
			<td>حقوق پایه</td>
			<td>حذف</td>
		</tr>
    <?php
    $db->query("select * from people order by status,name");
    $res=$db->result();
    $i=1;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row[name]; ?></td>
            <td><?php echo $row[mobile]; ?></td>
			<td><?php if ($row['status']=="1") echo "غیرفعال"; ?></td>
            <td><a href="index.php?pid=settings.people&person_id=<?php echo $row[id]; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
			<td><a href="index.php?pid=settings.people&person_id=<?php echo $row[id]; ?>&func=access"><img src="../images/buttons/access.png" border="0"></a></td>
			<td><a href="index.php?pid=settings.people&person_id=<?php echo $row[id]; ?>&func=rollcall"><img src="../images/buttons/rollcall.png" border="0"></a></td>
			<td><a href="index.php?pid=settings.people&person_id=<?php echo $row[id]; ?>&func=payments"><img src="../images/buttons/payments.png" border="0"></a></td>
			<td><a href="index.php?pid=settings.people&person_id=<?php echo $row[id]; ?>&func=base_wage"><img src="../images/buttons/people_base_wage.png" border="0"></a></td>
			
            <td><a href='#' onclick="confirm_delete('<?php echo $row[id]; ?>','index.php?pid=settings.people&person_id=<?php echo $row[id]; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
        </tr>
        <?php   
    }
	?>
	</table>
<?php
}
?>