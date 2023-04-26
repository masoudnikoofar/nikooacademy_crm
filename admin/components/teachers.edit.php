<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['teacher_id']))
{
	$teacher_id=$db->mysql_real_escape_string($_GET['teacher_id']);
}
if ($_POST[step]=="2")
{
    include("teachers.edit.step2.php");
}


$db->query("select * from teachers where id='".$teacher_id."'");
$res=$db->result();
$row=$res[0];

$id=$row['id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$tel=$row['tel'];
$mobile=$row['mobile'];
$address=$row['address'];
$email=$row['email'];
$reg_date=$row['reg_date'];
$job=$row['job'];
$education=$row['education'];
$birth_date=$row['birth_date'];
$IT_history=$row['IT_history'];
$operator_id=$row['operator_id'];
$account_info=$row['account_info'];
$cooperate_date=$row['cooperate_date'];


$db->query("select * from users where id='".$operator_id."'");
$res2=$db->result();
$operator=$res2[0]['fullname'];
?>
<form method="POST" enctype="multipart/form-data">
	<input type="hidden" name="step" value="2">
    <table class="tables" width="80%">
		<tr class="tablesheader"><td colspan="5">اطلاعات استاد - کد استاد : <?php echo $id; ?></td></tr>
		<tr class="odd"> 
			<td align="left"><b>نام :</b></td>
			<td><input type="text" name="firstname" value="<?php echo $firstname; ?>" size="20"></td>
			<td align="left"><b>نام خانوادگی :</b></td>
			<td><input type="text" name="lastname" value="<?php echo $lastname; ?>" size="20"></td>
			<td rowspan="6">
				<?php
				if (file_exists("../uploads/images_teachers/".$teacher_id.".jpg"))
				{
					?>
					<img src="../uploads/images_teachers/<?php echo $teacher_id; ?>.jpg" width="200px">
					<?php
				}
				else
				{
					?>
					<img src="../uploads/unknown.png" width="200px">
					<?php
				}
				?>
			</td>
		</tr>
		<tr class="odd">
			<td align="left"><b>تلفن :</b></td>
			<td><input type="text" name="tel" value="<?php echo $tel; ?>" size="20" id="tel"></td>
			<td align="left"><b>تلفن همراه :</b></td>
			<td><input type="text" name="mobile" value="<?php echo $mobile; ?>" size="20"></td>
		</tr>
		<tr>
			<td align="left"><b>ایمیل :</b></td>
			<td><input type="text" name="email" value="<?php echo $email; ?>" size="20"></td>
			<td align="left"><b>تاریخ تولد :</b></td>
			<td><input type="text" name="birth_date" size="20" value="<?php echo $birth_date; ?>" dir="ltr"><?php calendar("birth_date"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>شغل :</b></td>
			<td><input type="text" name="job" value="<?php echo $job; ?>" size="20"></td>
			<td align="left"><b>تحصیلات :</b></td>
			<td><input type="text" name="education" value="<?php echo $education; ?>" size="20"></td>
		</tr>
		<tr>
			<td align="left"><b>آدرس :</b></td>
			<td><textarea  rows="3" name="address" cols="30"><?php echo $address; ?></textarea></td>
			<td align="left"><b>سابقه فناوری اطلاعات :</b></td>
			<td><textarea  rows="3" name="IT_history" cols="30"><?php echo $IT_history; ?></textarea></td>
		</tr>
		<tr class="odd">
			<td valign="top" align="left"><b>رزومه:</b></td>
			<td valign="top"><input type="file" name="resume" id="resume"></td>
			<td align="left"><b>اطلاعات حساب :</b></td>
			<td><textarea  rows="3" name="account_info" cols="30"><?php echo $account_info; ?></textarea></td>
		</tr>
		<tr>
			<td align="left"><b>تاریخ شروع همکاری :</b></td>
			<td><input type="text" name="cooperate_date" size="20" value="<?php echo $cooperate_date; ?>" dir="ltr"><?php calendar("cooperate_date"); ?></td>
		</tr>
		<tr class="odd">
			<td align="left"><b>نام اپراتور :</b></td>
			<td><input type="text" name="operator" size="20" readonly="true" value="<?php echo $operator; ?>" /></td>
			
			<td valign="top" align="left"><b>عکس:</b></td>
			<td valign="top"><input type="file" name="image" id="image"></td>
<!--
			<td align="left"><b>تاریخ ثبت :</b></td>
			<td><input type="text" name="reg_date" size="20" readonly="true" value="<?php echo $reg_date; ?>" dir="ltr"><?php calendar("cooperate_date"); ?></td>
-->
		</tr>
		<tr>
			<td colspan="4"  align="center"><button type="submit">ویرایش</button></td>
		</tr>
	</table>
</form>