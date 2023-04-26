<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST[step]=="2")
{
    if ($operator_level=="4")
    {
        $db->query("update people set 
        level='".$_POST['level']."'
        where ID='$person_id'
        ");
    }
    $db->query("update people set 
    name='$_POST[name]',
    user='$_POST[username]'
    where ID='$person_id'
    ");
    if ($_POST[password]!="")
    {
        $db->query("update people set 
        pass='".md5($_POST['password'])."'
        where ID='$person_id'
        "); 
    }
    alert("با موفقیت ثبت شد");
}
$db->query("select * from people where id='$person_id'");
$res=$db->result();
$row=$res[0];
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table class="tables" width="50%">
<tr class="tablesheader">
    <td colspan="2">ویرایش کاربر</td>
</tr>
<tr>
    <td align="left"><b>نام و نام خانوادگی کاربر:</b></td>
    <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
</tr>
<tr>
    <td align="left"><b>username:</b></td>
    <td><input type="text" name="username" value="<?php echo $row['user']; ?>"></td>
</tr>
<tr>
    <td align="left"><b>password:</b></td>
    <td><input type="password" name="password"></td>
</tr>
<?php
if ($operator_level=="4")
{
?>
<tr>
    <td align="left"><b>سطح دسترسی:</b></td>
    <td>
        <select name="level">
            <option value="0" <?php if ($row['level']=="0") echo "selected"; ?>>عدم دسترسی</option>
            <option value="1" <?php if ($row['level']=="1") echo "selected"; ?>>مدیر ارشد</option>
            <option value="2" <?php if ($row['level']=="2") echo "selected"; ?>>کاربر ویژه</option>
            <option value="3" <?php if ($row['level']=="3") echo "selected"; ?>>کاربر معمولی</option>
            <option value="4" <?php if ($row['level']=="4") echo "selected"; ?>>administrator</option>
        </select>
    </td>
</tr>

<?php
}
?>
<tr>
    <td colspan="2" align="center"><button type="submit">ویرایش</button></td>
</tr>
</table>
</form>
<?php
$db->query("select * from users_login_log where user_id='$person_id' order by id desc");
$res=$db->result();
?>
<table width="100%" class="tableslistr" border="1">
    <tr class="tablesheader">
        <td>ردیف</td>
        <td>تاریخ</td>
        <td>ساعت</td>
    </tr>
        <?php
        $i=0;
        foreach ($res as $row)
        {
            $i++;
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$row[date]</td>";
            echo "<td>$row[time]</td>";
            echo "</tr>";   
        }
    ?>
</table>