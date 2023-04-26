<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<pre>
<?php
$db->query("select * from teachers where id='".$teacher_id."'");
$res=$db->result();
$row=$res[0];
print_r($row);
$id=$row['id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$national_code=$row['national_code'];
$mobile=$row['mobile'];
$email=$row['email'];


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
$db->query("update teachers set moodle_user_id='".$moodle_user_id."' where id='".$student_id."'");
?>

