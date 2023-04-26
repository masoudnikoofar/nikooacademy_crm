<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET[room_id]))
{
    $room_id=$_GET[room_id];
}
if ($_GET['func']=="add")
{
	$popup_arguments=array("pid"=>"settings.rooms.add");
    popup($popup_arguments);
}
else if ($_GET['func']=="edit")
{
    include("components/settings.rooms.edit.php");
}
else if ($_GET['func']=="edit")
{
    include("components/settings.rooms.edit.php");
}
else if ($_GET['func']=="delete")
{
    //$db->query("delete from rooms where id='$room_id'");
    //alert("با موفقیت حذف شد");
    //goback("index.php?pid=rooms");
	alert("در حال حاضر امکان حذف اتاق وجود ندارد");
}
else
{
    ?>
    <a href="index.php?pid=settings.rooms&func=add"><img src="../images/buttons/add.png" border="0"><br/>اضافه کردن اتاق جدید</a>
    <br />
    <table class="tableslistr" border="1" width="50%">
        <tr class="tablesheader">
			<td>ردیف</td>
            <td>عنوان اتاق</td>
			<td>ویرایش</td>
			<td>حذف</td>
		</tr>
    <?php
    $db->query("select * from rooms order by id desc");
    $res=$db->result();
    $i=1;
    foreach ($res as $row)
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><a href="index.php?pid=settings.rooms&room_id=<?php echo $row[id]; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
            <td><a href='#' onclick="confirm_delete('<?php echo $row[id]; ?>','index.php?pid=settings.rooms&room_id=<?php echo $row[id]; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
        </tr>
        <?php   
    }
	?>
	</table>
<?php
}
?>