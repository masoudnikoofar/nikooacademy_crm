<?php
$national_code=trim($national_code," \n\r\t\v\x00");
$mobile=trim($mobile," \n\r\t\v\x00");
$email=trim($email," \n\r\t\v\x00");

if ($email=="")
{
	$email = "email".$mobile."@nikoo-academy.com";
}
$new_user = array('users' => array(array(
	 'username' => $mobile          
	,'auth' => 'manual'                
	,'password' => 'aA@'.$mobile                
	,'firstname' => $firstname                
	,'lastname' => $lastname           
	,'email' => $email
)));
$return = $MoodleRest->request('core_user_create_users', $new_user, MoodleRest::METHOD_POST);
$moodle_user_id=$return[0]['id'];
$db->query("update students set moodle_user_id='".$moodle_user_id."' where id='".$student_id."'");
?>