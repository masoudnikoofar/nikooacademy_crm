<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$x="";

if ($_POST['firstname']!="")
{
    $x.=" and firstname like '%".$_POST['firstname']."%'";
}
if ($_POST['lastname']!="")
{
    $x.=" and lastname like '%".$_POST['lastname']."%'";
}


if ($_POST['id']!="")
{
    $x.=" and id='".$_POST['id']."'";
}
if ($_POST['tel']!="")
{
    $x.=" and tel='".$_POST['tel']."'";
}
if ($_POST['mobile']!="")
{
    $x.=" and mobile='".$_POST['mobile']."'";
}
$start=0;
if ($_POST['start']!="")
    $start=$_POST['start'];
$i=$start;
$db->query("select count(*) as count from teachers where 1 $x");
$res=$db->result();
$count=$res[0]['count'];
$db->query("select * from teachers where 1 $x order by id desc LIMIT $start , $limit ");
$res=$db->result();
?>
<?php
$variables=array(
"step",
"firstname",
"lastname",
"tel",
"mobile",
"id"
);
?>
<table class="tableslistr" width="100%">
    <tr>
        <td width="100">
            <?php
            forward_button($variables,$start,$limit,$count);
            ?>
        </td>
        <td>
        <?php 
        if ($start+$limit<$count)
            echo $start."-".($start+$limit)."/".$count; 
        else
            echo $start."-".$count."/".$count;
        ?>
        </td>
        <td width="100">
            <?php
            backward_button($variables,$start,$limit,$count);
            ?>
        </td>
    </tr>
</table>
<table class="tableslistr" width="100%" border="1">
<tr class="tablesheader"> 
    <td>ردیف</td>
    <td>نام استاد</td>
    <td>همراه</td>
    <td>تلفن</td>
    <td>کد استاد</td>
    <td>دوره ها</td>
    <td>پرداخت ها</td>
	<td>ارسال به مودل</td>
    <td>ویرایش</td>
    <td>حذف</td>
</tr>
<?php
foreach ($res as $row)
{   
    $i++;
    $name=$row['firstname']." ".$row['lastname'];
    $tel=$row['tel']; 
    $mobile=$row['mobile']; 
    
    ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $name; ?></td>
        <td><?php echo $mobile; ?></td>
        <td><?php echo $tel; ?></td> 
        <td><?php echo $row['id']; ?></td>
        <td><a href="index.php?pid=teachers&teacher_id=<?php echo $row['id']; ?>&func=courses"><img src="../images/buttons/courses.png" border="0"></a></td>
		<td><a href="index.php?pid=teachers&teacher_id=<?php echo $row['id']; ?>&func=payments"><img src="../images/buttons/payments.png" border="0"></a></td>
        <td><a href="index.php?pid=teachers&teacher_id=<?php echo $row['id']; ?>&func=send_to_moodle"><img src="../images/buttons/moodle.png" border="0"></a></td>
        <td><a href="index.php?pid=teachers&teacher_id=<?php echo $row['id']; ?>&func=edit"><img src="../images/buttons/edit.gif" border="0"></a></td>
        <td><a href='#' onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=teachers&teacher_id=<?php echo $row['id']; ?>&func=delete')"><img src="../images/buttons/delete.gif" border="0"></a></td>
    </tr>
<?php
}
?>
</table>