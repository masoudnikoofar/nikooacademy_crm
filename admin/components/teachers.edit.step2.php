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
$works_of_art=$db->mysql_real_escape_string($_POST['works_of_art']);
$account_info=$db->mysql_real_escape_string($_POST['account_info']);
$cooperate_date=$db->mysql_real_escape_string($_POST['cooperate_date']);

$db->query("update teachers set 
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
	account_info='$account_info',
	cooperate_date='$cooperate_date'
	where id='$teacher_id'");
	$target_dir = "../uploads/images_teachers/";
	$target_file = $target_dir . $teacher_id . ".jpg";
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
				echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
			}
		}
	}
	
alert("با موفقیت ویرایش شد");
goback("index.php?pid=teachers");
?>