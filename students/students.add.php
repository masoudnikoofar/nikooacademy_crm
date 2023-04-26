<?php
$form_show = true;
if ($_POST['step']=="2")
{	
	$tel=$db->mysql_real_escape_string($_POST['tel']);
	$mobile=$db->mysql_real_escape_string($_POST['mobile']);
	$address=$db->mysql_real_escape_string($_POST['address']);
	$email=$db->mysql_real_escape_string($_POST['email']);
	$firstname=$db->mysql_real_escape_string($_POST['firstname']);
	$lastname=$db->mysql_real_escape_string($_POST['lastname']);
	$sex=$db->mysql_real_escape_string($_POST['sex']);
	$national_code=$db->mysql_real_escape_string($_POST['national_code']);
	$reg_date=$db->mysql_real_escape_string($_POST['reg_date']);
	$IT_history=$db->mysql_real_escape_string($_POST['IT_history']);
	$education=$db->mysql_real_escape_string($_POST['education']);
	$job=$db->mysql_real_escape_string($_POST['job']);
	$birth_date=$db->mysql_real_escape_string($_POST['birth_date']);

	$db->query("select * from students where mobile='".$mobile."' or email='".$email."' or national_code='".$national_code."'");
	$res_tmp = $db->result();
	if (count($res_tmp)>0)
	{
		$is_exist = 1;
		$row_tmp = $res_tmp[0];
	}
	if ($firstname=="" || $lastname=="" || $national_code=="" || $sex=="" || $email=="" || $mobile=="")
	{
		alert("تکمیل فیلد های ستاره دار الزامی است");
	}
	else if ($is_exist==1)
	{
		if ($mobile==$row_tmp['mobile'])
		{
			alert("این شماره موبایل قبلا در سیستم ثبت شده است");
		}
		if ($national_code==$row_tmp['national_code'])
		{
			alert("این کد ملی قبلا در سیستم ثبت شده است");
		}
		if ($email==$row_tmp['email'])
		{
			alert("این ایمیل قبلا در سیستم ثبت شده است");
		}	
	}
	else if (strlen($mobile)!=11 || substr($mobile,0,2)!="09")
	{
		alert("فرمت شماره موبایل اشتباه است");
	}
	else if (strlen($national_code)!=10)
	{
		alert("فرمت کد ملی اشتباه است");
	}
	else
	{
		$form_show = false;
		$db->query("insert into students set 
			tel='$tel',
			mobile='$mobile',
			address='$address',
			email='$email',
			firstname='$firstname',
			lastname='$lastname',
			sex='$sex',
			national_code='$national_code',
			operator_id='100',
			reg_date='$reg_date',
			IT_history='$IT_history',
			education='$education',
			job='$job',
			birth_date='$birth_date'
		");
			
		$db->query("select id from students order by id desc limit 0,1");
		$res=$db->result();
		$row=$res['0'];
		$student_id=$row['id'];
		
		
		
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
		//include("api.php");
		//include("sms.php");
		$sms_text= $firstname." ".$lastname." عزیز به آکادمی هوش مصنوعی نیکو خوش آمدید\n";
		$sms_text .= "همکاران ما در اسرع وقت با شما تماس خواهند گرفت\n";
		$sms_text .= "از اعتماد و صبر شما سپاسگذاریم";
		sms_send($mobile,$sms_text);
		alert("ثبت با موفقیت انجام شد. همکاران ما در اسرع وقت با شما تماس خواهند گرفت");
		goback_parent("https://nikoo-academy.com/");
	}
}		

if ($form_show == true)
{
	include("students.add.step1.php");
}
?>	