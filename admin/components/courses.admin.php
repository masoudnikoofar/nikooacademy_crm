<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['course_id']))
{
    $course_id=$_GET['course_id'];
}

if ($_GET['func']=="add")
{
    //popup(array("pid"=>"courses.add"));
	//	goback("index.php?pid=courses
	include("components/courses.add.php");
}
else if ($_GET['func']=="send_to_moodle")
{
    include("components/courses.send_to_moodle.php");
}
else if ($_GET['func']=="sessions")
{
    include("components/courses.sessions.php");
}
else if ($_GET['func']=="students")
{
	if ($func2=="send_to_moodle")
	{
		include("components/courses.students.send_to_moodle.php");
	}
    include("components/courses.students.add.php");
    include("components/courses.students.list.php");
}
else if ($_GET['func']=="edit")
{
    include("components/courses.edit.php");
}
else if ($_GET['func']=="delete")
{
    $db->query("delete from courses where id='$course_id'");
    alert("با موفقیت حذف شد");
    goback("index.php?pid=courses");
}
else
{
	include("components/courses.list.php");
}
?>
