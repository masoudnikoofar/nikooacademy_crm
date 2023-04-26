<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['course_category_id']))
{
    $course_category_id=$_GET['course_category_id'];
}

if ($_GET['func']=="add")
{
	include("components/courses_categories.add.php");
}
else if ($_GET['func']=="send_to_moodle")
{
    include("components/courses_categories.send_to_moodle.php");
}
else if ($_GET['func']=="edit")
{
    include("components/courses_categories.edit.php");
}
else if ($_GET['func']=="delete")
{
    $db->query("delete from courses_categories where id='".$course_category_id."'");
    alert("با موفقیت حذف شد");
    goback("index.php?pid=courses_categories");
}
else
{
	include("components/courses_categories.list.php");
}
?>
