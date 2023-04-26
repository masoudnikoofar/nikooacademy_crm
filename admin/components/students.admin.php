<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['student_id']))
{
    $student_id=$db->mysql_real_escape_string($_GET['student_id']);
	$db->query("select * from students where id='".$student_id."'");
	$res=$db->result();
	$row=$res[0];
	?>
	<table class="tables" width="100%">
		<tr class="tablesheader">
			<td><?php echo $row['firstname']." ".$row['lastname']; ?> (<?php echo $row['id']; ?>)</td>
		</tr>
	</table>
	<?php
}
if (isset($_GET['func']))
{
    $func=$db->mysql_real_escape_string($_GET['func']);
}
if (isset($_GET['func2']))
{
    $func2=$db->mysql_real_escape_string($_GET['func2']);
}
if (isset($_GET['func3']))
{
    $func3=$db->mysql_real_escape_string($_GET['func3']);
}


if ($func=="add")
{
    include("components/students.add.php");
}
else if ($func == "send_to_moodle")
{
	include("components/students.send_to_moodle.php");
}
else if ($func=="courses")
{	
	if (isset($_GET['course_student_id']))
	{
		$course_student_id=$db->mysql_real_escape_string($_GET['course_student_id']);
		$db->query("select * from courses_students where id='".$course_student_id."'");
		$res=$db->result();
		$row=$res[0];
		$db->query("select * from courses where id='".$row['course_id']."'");
		$res2=$db->result();
		$row2=$res2[0];
		$course_title=$row2['title'];
		$teacher_id=$row2['teacher_id'];
		$db->query("select * from teachers where id='".$teacher_id."'");
		$res2=$db->result();
		$row2=$res2[0];
		$teacher_fullname=$row2['firstname']." ".$row2['lastname'];
		?>
		<table class="tables" width="100%">
			<tr class="tablesheader">
				<td><?php echo $course_title." - ".$teacher_fullname; ?></td>
			</tr>
		</table>
		<?php
	}
	
	if ($func2=="payments")
    {
		if (isset($_GET['student_course_payment_id']))
		{
			$student_course_payment_id=$db->mysql_real_escape_string($_GET['student_course_payment_id']);
		}
		if ($func3=="add")
		{
			include("components/students.courses.payments.add.php");
		}
        else if ($func3=="edit")
		{
			/*
			$popup_arguments=array(
				"pid"=>"students.courses.registrations.payments.edit&student_course_registration_payment_id=".$student_course_registration_payment_id,
				"parent_redirect"=>true,
				"parent_redirect_url"=>"index.php?pid=students&student_id=".$student_id."&func=courses&course_student_id=".$course_student_id."&func2=registrations.list"
			);
			popup($popup_arguments);
			*/
		}
		else if ($func3=="delete")
		{
			$db->query("delete from students_courses_payments where id='".$student_course_payment_id."'");
			alert("با موفقیت حذف شد");
		}
		else
		{
			/*
			$popup_arguments=array(
				"pid"=>"students.courses.payments.add&course_student_id=".$course_student_id,
				"parent_redirect"=>true,
				"parent_redirect_url"=>"index.php?pid=students&student_id=".$student_id."&func=courses&course_student_id=".$course_student_id.""
			);
			popup($popup_arguments);
			*/
			include("components/students.courses.payments.php");
		}
    }
    /*
	else if ($func2=="add")
	{
		include("components/students.courses.add.php");
	}
	else if ($func2=="edit")
	{
		include("components/students.courses.edit.php");
	}
	else if ($func2=="delete")
	{
		$db->query("delete from students_courses where id='".$course_student_id."'");
	}
	
	else if ($func2=="teachers_share")
	{
		include("components/students.courses.teachers_share.php");
	}
	*/
	else if ($func2=="status")
	{
		$inactive=$db->mysql_real_escape_string($_GET['inactive']);
		$db->query("update courses_students set inactive='".$inactive."' where id='".$course_student_id."'");
		alert("با موفقیت به روز رسانی شد");
		goback("index.php?pid=students&student_id=".$student_id."&func=courses");
	}
	else
	{
		include("components/students.courses.php");
	}
}
else if ($func=="invoices")
{
    if (isset($_GET['invoice_id']))
	{
		$invoice_id=$db->mysql_real_escape_string($_GET['invoice_id']);
	}
	if (isset($_GET['student_good_id']))
	{
		$student_good_id=$db->mysql_real_escape_string($_GET['student_good_id']);
	}

	if ($func2=="add")
	{
		$popup_arguments=array(
			"pid"=>"students.invoices.add&student_id=".$student_id,
			"parent_redirect"=>true,
			"parent_redirect_url"=>"index.php?pid=students&student_id=".$student_id."&func=invoices"
		);
		popup($popup_arguments);
	}
	else if ($func2=="edit")
	{
		if ($func3=="good.gift")
		{
			$is_gift=$_GET['is_gift'];
			$db->query("update invoices_goods set is_gift='".$is_gift."' where id='".$student_good_id."'");
		}
		else if ($func3=="good.delete")
		{
			//edit log of goods
			$db->query("select * from invoices_goods where id='".$student_good_id."'");
			$res=$db->result();
			$row=$res[0];
			$good_id=$row['good_id'];
			$good_number=$row['number'];
			$good_price=$row['price'];
			$student_id=$row['student_id'];
			$invoice_id=$row['invoice_id'];
			
			$good_log_args=array(
			"transaction_type"=>5,
			"invoice_date"=>$today,
			"good_id"=>$good_id,
			"number"=>$good_number,
			//"price_one_buy"=>$price_one_buy,
			"price_one_sell"=>$good_price,
			//"invoice_no_buy"=>$invoice_no_buy,
			"student_id"=>$student_id,
			"student_invoice_id"=>$invoice_id
			//"comment"=>$comment
		);
		good_log($good_log_args);

			//+++++++++++++++
			
			$db->query("update goods set number=number+".$good_number." where id='".$good_id."'");
			$db->query("delete from invoices_goods where id='".$student_good_id."'");
			
			
			
			alert("با موفقیت حذف شد");
		}
		//popup(array("pid"=>"students.invoices.edit&student_id=".$student_id."&invoice_id=".$invoice_id));
		include("components/students.invoices.edit.php");
	}
	else if ($func2=="print")
	{
		$popup_arguments=array(
			"pid"=>"students.invoices.print&student_id=".$student_id."&invoice_id=".$invoice_id,
			"parent_redirect"=>true,
			"parent_redirect_url"=>"index.php?pid=students&student_id=".$student_id."&func=invoices",
			"width"=>800,
			"heigth"=>600
		);
		popup($popup_arguments);
	}
	else 
	{	
		include("components/students.invoices.php");
	}
}
else if ($func=="edit")
{
    include("components/students.edit.php");
}
else if ($func=="delete")
{
    $db->query("delete from students where id='$student_id'");

    alert("با موفقیت حذف شد");
    goback("index.php?pid=students");
}
else
{
    include("components/students.list.php");
}
?>	