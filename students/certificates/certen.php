<?php
header("Content-type: image/jpeg");
$imgPath = 'cert_EN.jpg';
$image = imagecreatefromjpeg($imgPath);

include_once("../config/config.php");
include_once("../classes/class_database.php");  
$db = new database();

$cert_id=$db->mysql_real_escape_string($_GET['cert_id']);

$db->query("select * from certificates where id='".$cert_id."'");
$res = $db->result();
if (count($res)<1)
{
    die;
}

$row = $res[0];
$student_id = $row['student_id'];
$course_id = $row['course_id'];
$issue_date = $row['issue_date'];
$issue_date = explode("-",$issue_date);


$date = $issue_date[0]." / ".$issue_date[1]." / ".$issue_date[2];
$certno = str_pad($student_id,6,"0")." - ".str_pad($course_id,6,"0");


$db->query("select * from students where id='".$student_id."'")
$res = $db->result();
$row = $res[0];
$name = $row['firstname_en']." ".$row['lastname_en'];

$db->query("select * from courses where id='".$course_id."'")
$res = $db->result();
$row = $res[0];
$db->query("select * from courses_categories where id='".$row['category_id']."'")
$res = $db->result();
$row = $res[0];
$course = $row['title_en'];


$name_color = imagecolorallocate($image, 87, 87, 86);
$name_font_size = 200;
$name_font = "./Sacramento-Regular.ttf";
$x = 300;
$y = 1500;
imagettftext($image, $name_font_size, 0, $x, $y, $name_color, $name_font, $name);


$course_color = imagecolorallocate($image, 60, 60, 59);
$course_font_size = 55;
$course_font = "./Rubik-Bold.ttf";
$x = 1280;
$y = 1740;
imagettftext($image, $course_font_size, 0, $x, $y, $course_color, $course_font, $course);


$date_color = imagecolorallocate($image, 60, 60, 59);
$date_font_size = 50;
$date_font = "./Rubik-Regular.ttf";
$x = 1200;
$y = 2200;
imagettftext($image, $date_font_size, 0, $x, $y, $date_color, $date_font, $date);

$certno_color = imagecolorallocate($image, 60, 60, 59);
$certno_font_size = 50;
$certno_font = "./Rubik-Regular.ttf";
$x = 2100;
$y = 2200;
imagettftext($image, $certno_font_size, 0, $x, $y, $certno_color, $certno_font, $certno);



imagejpeg($image);
?> 