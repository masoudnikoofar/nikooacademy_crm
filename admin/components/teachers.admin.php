<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['teacher_id']))
{
    $teacher_id=$_GET['teacher_id'];
}

if (isset($_GET['func']))
{
    $func=$db->mysql_real_escape_string($_GET['func']);
}
if (isset($_GET['func2']))
{
    $func2=$db->mysql_real_escape_string($_GET['func2']);
}
if (isset($_GET['func3']))
{
    $func3=$db->mysql_real_escape_string($_GET['func3']);
}


if ($func=="add")
{
    include("components/teachers.add.php");
}
else if ($func == "send_to_moodle")
{
	include("components/teachers.send_to_moodle.php");
}
else if ($func=="courses")
{
    include("components/teachers.courses.php");
}
else if ($func=="edit")
{
    include("components/teachers.edit.php");
}
else if ($func=="delete")
{
    $db->query("delete from teachers where id='".$teacher_id."'");

    alert("با موفقیت حذف شد");
    goback("index.php?pid=teachers");
}
else if ($func=="payments")
{
    include("components/teachers.payments.admin.php");
}
else
{
    include("components/teachers.list.php");
}
?>