<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$operator_id=$_SESSION['admin.'.$company_name_en.'_user_id'];
$operator_level=$_SESSION['admin.'.$company_name_en.'_user_level'];
$db->query("select * from users where id='$operator_id'");
$res=$db->result();
$row=$res[0];
$user_fullname=$row['fullname'];
?>
<table class="taskbar" width="100%" cellpadding="0" cellspacing="0">
<tr><td valign="center">
    <img src='../images/buttons/users.png'><a href="index.php?pid=users"><?php echo "<b>$user_fullname</b>"; ?></a> 
    <?php
    $db->query("select * from users_login_log where user_id='$operator_id' order by id desc");
    $res=$db->result();
    $row=$res[1];
    ?>
    (آخرین ورود= تاریخ:<?php echo $row['date']; ?> - ساعت:<?php echo $row['time']; ?>)
    | 
    <img src='../images/buttons/calendar.png'><?php echo "<span dir=rtl><b>$today</b></span>"; ?>
</td>
<td align="left" valign="center"><b><a href="index.php?signout=true">خروج</a></b></td>
</tr>
</table>
