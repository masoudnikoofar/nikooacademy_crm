<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET[semester_id]))
{
    $semester_id=$_GET[semester_id];
}
if ($_GET['func']=="add")
{
	$popup_arguments=array("pid"=>"settings.semesters.add");
    popup($popup_arguments);
}
else if ($_GET['func']=="edit")
{
    include("components/settings.semesters.edit.php");
}
else if ($_GET['func']=="edit")
{
    include("components/settings.semesters.edit.php");
}
else if ($_GET['func']=="set.current")
{
    $db->query("update semesters set is_current=0 where is_current<>0");
	$db->query("update semesters set is_current=1 where id='".$semester_id."'");
	goback("index.php?pid=settings.semesters");
}
else if ($_GET['func']=="delete")
{
    //$db->query("delete from semesters where id='$semester_id'");
    //alert("با موفقیت حذف شد");
    //goback("index.php?pid=semesters");
	alert("در حال حاضر امکان حذف افراد وجود ندارد");
}
else
{
    ?>
    <a href="index.php?pid=settings.semesters&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن ترم جدید</a>
    <br />
    <table class="tableslistr" border="1" width="50%">
        <tr class="tablesheader">
			<td>ردیف</td>
            <td>عنوان ترم</td>
            <td>تاریخ شروع</td>
			<td>تاریخ پایان</td>
			<td>ترم جاری</td>
			<td>ویرایش</td>
			<td>حذف</td>
		</tr>
    <?php
    $db->query("select * from semesters order by id desc");
    $res=$db->result();
    $i=1;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['finish_date']; ?></td>
            <td>
				<?php 
				if ($row['is_current']<>"1")
				{
				?>
					<a href="index.php?pid=settings.semesters&semester_id=<?php echo $row[id]; ?>&func=set.current"><img src="../images/buttons/active.png" border="0"></a>
				<?php
				}
				?>
			</td>
            <td><a href="index.php?pid=settings.semesters&semester_id=<?php echo $row[id]; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
            <td><a href='#' onclick="confirm_delete('<?php echo $row[id]; ?>','index.php?pid=settings.semesters&semester_id=<?php echo $row[id]; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
        </tr>
        <?php   
    }
	?>
	</table>
<?php
}
?>