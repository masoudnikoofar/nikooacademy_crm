<form method="POST">
	<input type="hidden" name="step" value="2">
	<table class="tables" width="100%">
		<tr class="tablesheader">
			<td valign="middle" colspan="2">
				دانشجوی گرامی، با سلام و احترام و ضمن خوشامد گویی به جنابعالی<br/>
				خواهشمند است فرم زیر را به دقت تکمیل نمایید.<br/>
				لازم به ذکر است پرکردن فیلدهای ستاره دار اجباری می باشد.
				<br/>
				<br/>
			</td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>نام *:</b></td>
			<td valign="middle"><input type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>" size="20"></td>
		</tr>
		<tr>	
			<td valign="middle" align="left"><b>نام خانوادگی *:</b></td>
			<td valign="middle"><input type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>" size="20" id="lname"></td>
		</tr>
		<tr>	
			<td valign="middle" align="left"><b>کد ملی *:</b></td>
			<td valign="middle"><input type="text" name="national_code" value="<?php echo $_POST['national_code']; ?>" placeholder="0012345678" pattern="[0-9]{10}" size="20" id="lname"></td>
		</tr>
		
		<tr>
			<td valign="middle" align="left"><b>جنسیت *:</b></td>
			<td valign="middle">
				<input type="radio" name="sex" value="f" <?php if ($_POST['sex']=="f") echo "checked"; ?>> زن
				<input type="radio" name="sex" value="m" <?php if ($_POST['sex']=="m") echo "checked"; ?>> مرد
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="left"><b>تلفن:</b></td>
			<td valign="middle"><input type="text" name="tel" value="<?php echo $_POST['tel']; ?>" size="20" placeholder="08132521174" pattern="[0-9]{11}" id="tel"></td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>تلفن همراه *:</b></td>
			<td valign="middle"><input type="text" name="mobile" value="<?php echo $_POST['mobile']; ?>" placeholder="09197582467" pattern="[0-9]{11}" id="mobile" size="20"></td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>ایمیل *:</b></td>
			<td valign="middle"><input type="text" name="email" value="<?php echo $_POST['email']; ?>" placeholder="info@nikooacademy.com" size="20" id="email"></td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>تاریخ تولد:</b></td>
			<td valign="middle"><input type="text" name="birth_date" value="<?php echo $_POST['birth_date']; ?>" placeholder="1365-11-19" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" dir="ltr"><?php calendar("birth_date"); ?></td>			
		</tr>
		<tr>
			<td valign="middle" align="left"><b>شغل:</b></td>
			<td valign="middle"><input type="text" name="job" value="<?php echo $_POST['job']; ?>" size="20" id="job"></td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>تحصیلات:</b></td>
			<td valign="middle"><input type="text" name="education" value="<?php echo $_POST['education']; ?>" size="20" id="education"></td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>آدرس:</b></td>
			<td valign="middle"><textarea  rows="3" name="address" cols="30" id="address"><?php echo $_POST['address']; ?></textarea></td>
		</tr>
		<tr>
			<td valign="middle" align="left"><b>سابقه فناوری اطلاعات:</b></td>
			<td valign="middle"><textarea  rows="3" name="IT_history" cols="30" id="IT_history"><?php echo $_POST['IT_history']; ?></textarea></td>			
		</tr>
		
		
		<!--
		
		<tr>
			<td valign="middle" align="left"><b>دوره های انتخابی:</b></td>
			<td valign="middle">
				<?php
				$db->query("select * from courses_categories where parent_id=0 order by title");
				$res=$db->result();
			
				foreach ($res as $row)
				{
					?>
					<input type="checkbox" name="course_category_<?php echo $row['id']; ?>"><?php echo $row['title']; ?>
					<?php
				}
				
				?>			
			</td>			
		</tr>	
		

		<tr><td colspan="2"><hr/></td></tr>
		<?php
		$db->query("select * from courses_categories where parent_id=0 order by title");
		$res=$db->result();
		foreach ($res as $row)
		{
			?>
			<tr><td valign="top" align="left"><b><?php echo $row['title']; ?>:</b></td>
			<td>
			<?php
			$db->query("select * from courses_categories where parent_id='".$row['id']."' order by title");
			$res2=$db->result();
			foreach ($res2 as $row2)
			{
				?>
				<input type="checkbox" name="course_category_<?php echo $row2['id']; ?>"><?php echo $row2['title']; ?><br/>
				<?php
			}
			?>
			</td>
			</tr>
			<?php
		}
		?>
		-->
		<tr>
			<td valign="middle" colspan="2"  align="center"><button type="submit">ثبت</button></td>
		</tr>
	</table>
</form>
<script>
var mobile = document.querySelector('#mobile');

mobile.addEventListener('input', restrictNumber);
function restrictNumber (e) {  
  var newValue = this.value.replace(new RegExp(/[^\d]/,'ig'), "");
  this.value = newValue;
}
</script>