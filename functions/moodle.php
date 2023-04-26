<?php
function send_to_moodle_student($student_id)
{
	global $db;
	global $today_datetime;
	$db->query("select * from students where id='".$student_id."'");
	$res=$db->result();
	$row=$res[0];

	$id=$row['id'];
	$firstname=$row['firstname'];
	$lastname=$row['lastname'];
	$mobile=trim($row['mobile']," \n\r\t\v\x00");
	$email=trim($row['email']," \n\r\t\v\x00");

	if ($email=="")
	{
		$email = "email".$mobile."@nikoo-academy.com";
	}

	if ($firstname=="" || $lastname=="" || $mobile=="" || $email=="")
	{
		
	}
	else
	{
		$new_user = array('users' => array(array(
			'username' => $mobile          
			,'auth' => 'manual'                
			,'password' => 'aA@'.$mobile                
			,'firstname' => $firstname                
			,'lastname' => $lastname           
			,'email' => $email
		)));
		$return = $MoodleRest->request('core_user_create_users', $new_user, MoodleRest::METHOD_POST);
		//print_r($return);
		$moodle_user_id=$return[0]['id'];
		error_log("send_to_moodle_student ==> moodle_user_id:".$moodle_user_id);
		$db->query("update students set moodle_user_id='".$moodle_user_id."' where id='".$student_id."'");
		//alert("با موفقیت انجام شد");
	}
}
?>