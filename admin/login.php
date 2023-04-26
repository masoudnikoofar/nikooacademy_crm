<?php
if (isset($_GET['signout']))
{
	if ($_GET['signout']=="true")
	{
		$_SESSION['admin.'.$company_name_en.'_login']="";
	}
}
if (isset($_POST['step']))
{
	if ($_POST['step']=="login")
	{
		$username=$db->mysql_real_escape_string($_POST['username']);
		$password=$_POST['password'];
		$db->query("select * from users where user='".$username."'");
		$res=$db->result();
		echo $res[0]['id'];
		if($res[0]['pass']==md5($password) )
		{
			$_SESSION['admin.'.$company_name_en.'_login']="1";
			$_SESSION['admin.'.$company_name_en.'_user2']=$username;
			$_SESSION['admin.'.$company_name_en.'_user_id']=$res[0]['id'];
			$_SESSION['admin.'.$company_name_en.'_user_level']=$res[0]['level'];
			$db->query("insert into users_login_log set
			user_id='".$_SESSION['admin.'.$company_name_en.'_user_id']."',
			date='$today',
			time='$today_time'
			");
		}
	}
}
if ($_SESSION['admin.'.$company_name_en.'_login']=="1")
{
	include("admin.php");
	die;
}
else
{
	?>
	<div class="logincontent" width="100%" height="100%">
		<center>
			<img src="../images/logo.png">
			<form action="" method="POST">
				<input type="hidden" name="step" value="login">
				<table class="logintable">
					<tr>
						<td colspan="2">برای ورود این قسمت لطفا نام کاربری و کلمه عبور خود را وارد نمایید</td>
					</tr>
					<tr>
						<td align="left"><b>نام کاربری:</b></td>
						<td><input type="text" name="username" class="textinput"></td>
					</tr>
					<tr>
						<td align="left"><b>کلمه عبور:</b></td>
						<td><input type="password" name="password" class="textinput"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><button type="submit">ورود</button></td>
					</tr>
				</table>
			</form>
		</center>
	</div>
	<?php
	if (isset($_POST['username']))
	{
		alert("نام کاربری/کلمه عبور اشتباه است");
	}
} 
?>