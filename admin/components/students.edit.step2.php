<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$tel=$db->mysql_real_escape_string($_POST['tel']);
$mobile=$db->mysql_real_escape_string($_POST['mobile']);
$address=$db->mysql_real_escape_string($_POST['address']);
$email=$db->mysql_real_escape_string($_POST['email']);
$firstname=$db->mysql_real_escape_string($_POST['firstname']);
$lastname=$db->mysql_real_escape_string($_POST['lastname']);
$reg_date=$db->mysql_real_escape_string($_POST['reg_date']);
$job=$db->mysql_real_escape_string($_POST['job']);
$education=$db->mysql_real_escape_string($_POST['education']);
$birth_date=$db->mysql_real_escape_string($_POST['birth_date']);
$IT_history=$db->mysql_real_escape_string($_POST['IT_history']);
$inactive=$db->mysql_real_escape_string($_POST['inactive']);
if ($inactive=="on")
	$inactive="1";
else
	$inactive="0";

$db->query("update students set 
	tel='$tel',
	mobile='$mobile',
	address='$address',
	email='$email',
	firstname='$firstname',
	lastname='$lastname',
	job='$job',
	education='$education',
	birth_date='$birth_date',
	IT_history='$IT_history',
	inactive='$inactive'
	where id='$student_id'");
$target_dir = "../uploads/images_students/";
$target_file = $target_dir . $student_id . ".jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_FILES['ERROR']==0)
{
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if($check !== false) 
	{
		//echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} 
	else 
	{
		$uploadOk = 0;
	}
	if ($uploadOk == 1) 
	{
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) 
		{
			//echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
		}
	}
}
	
alert("با موفقیت ویرایش شد");
goback("index.php?pid=students");
?>