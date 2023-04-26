<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<pre>
<?php
$db->query("select * from courses where id='".$course_id."'");
$res=$db->result();
$row=$res[0];
$id=$row['id'];
$title=$row['title'];
$short_name="Code_".$id;
$category_id=$row['category_id'];
$teacher_id=$row['teacher_id'];

$db->query("select * from courses_categories where id='".$category_id."'");
$res2=$db->result();
$row2=$res2[0];
$moodle_category_id=$row2['moodle_category_id'];
$short_name= $row2['moodle_shortname_pattern']."_".$id;


$start_date=$row['start_date'];
$start_date_explode=explode("-",$start_date);
//$start_date=$row['start_date'];
$start_date_timestamp =  jDateTime::mktime(0, 0, 0, $start_date_explode[1], $start_date_explode[2], $start_date_explode[0], $jalali = true);

$new_course = array('courses' => array(array(
	 'fullname' => $title          
	,'shortname' => $short_name               
	,'categoryid' => $moodle_category_id           
	,'idnumber' => $id           
	,'startdate' => $start_date_timestamp           
)));

print_r($new_course);
$return = $MoodleRest->request('core_course_create_courses', $new_course, MoodleRest::METHOD_POST);
print_r($return);
$moodle_course_id=$return[0]['id'];
$db->query("update courses set moodle_course_id='".$moodle_course_id."' where id='".$course_id."'");


//////////////

$db->query("select * from teachers where id='".$teacher_id."'");
$res=$db->result();
$row=$res[0];

$moodle_user_id=$row['moodle_user_id'];

//teacher roleid=3 - student roleid=5


$new_enrolment = array('enrolments' => array(array(
	 'roleid' => 3          
	,'userid' => $moodle_user_id               
	,'courseid' => $moodle_course_id           
	,'timestart' => $start_date_timestamp
)));



print_r($new_enrolment);
$return = $MoodleRest->request('enrol_manual_enrol_users', $new_enrolment, MoodleRest::METHOD_POST);
print_r($return);
//$moodle_enrolment_id=$return[0]['id'];
//$db->query("update courses_students set moodle_enrolment_id='".$moodle_enrolment_id."' where id='".$course_student_id."'");

?>
