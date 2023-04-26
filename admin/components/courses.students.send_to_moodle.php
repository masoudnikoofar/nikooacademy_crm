<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<pre>
<?php
$db->query("select * from courses where id='".$course_id."'");
$res=$db->result();
$row=$res[0];
print_r($row);
$moodle_course_id=$row['moodle_course_id'];
$course_start_date=$row['start_date'];
$course_start_date_explode=explode("-",$course_start_date);
//$start_date=$row['start_date'];
$course_start_date_timestamp =  jDateTime::mktime(0, 0, 0, $course_start_date_explode[1], $course_start_date_explode[2], $course_start_date_explode[0], $jalali = true);

$db->query("select a.id,a.student_id,b.moodle_user_id from courses_students a,students b where a.student_id=b.id and course_id='".$course_id."'");
$res=$db->result();
foreach ($res as $row)
{
	$course_student_id=$row['id'];
	$student_id=$row['student_id'];
	$moodle_user_id=$row['moodle_user_id'];

	//teacher roleid=3 - student roleid=5


	$new_enrolment = array('enrolments' => array(array(
		 'roleid' => 5          
		,'userid' => $moodle_user_id               
		,'courseid' => $moodle_course_id           
		,'timestart' => $course_start_date_timestamp
	)));



	print_r($new_enrolment);
	$return = $MoodleRest->request('enrol_manual_enrol_users', $new_enrolment, MoodleRest::METHOD_POST);
	print_r($return);
	$moodle_enrolment_id=$return[0]['id'];
	$db->query("update courses_students set moodle_enrolment_id='".$moodle_enrolment_id."' where id='".$course_student_id."'");
}
?>
