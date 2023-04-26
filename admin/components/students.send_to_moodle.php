<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<pre>
<?php
$db->query("select * from students where id='".$student_id."'");
$res=$db->result();
$row=$res[0];

//trim(string $string, string $characters = " \n\r\t\v\x00")

$id=$row['id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$national_code=trim($row['national_code']," \n\r\t\v\x00");
$mobile=trim($row['mobile']," \n\r\t\v\x00");
$email=trim($row['email']," \n\r\t\v\x00");

if ($email=="")
{
	$email = "email".$mobile."@nikoo-academy.com";
}

if ($firstname=="" || $lastname=="" || $mobile=="" || $email=="")
{
	alert("فیلدها را کامل نمایید");
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
	print_r($return);
	$moodle_user_id=$return[0]['id'];
	$db->query("update students set moodle_user_id='".$moodle_user_id."' where id='".$student_id."'");
	alert("با موفقیت انجام شد");
}
?>