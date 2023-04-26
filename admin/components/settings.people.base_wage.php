<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if (isset($_GET['base_wage_id']))
{
	$base_wage_id=$_GET['base_wage_id'];
}

if ($_POST[step]=="2")
{
	if ($base_wage_id=="")
	{
		$db->query("insert into people_base_wage set 
		person_id='".$person_id."',
		start_date='".$_POST['start_date']."',
		end_date='".$_POST['end_date']."',
		base_wage='".$_POST['base_wage']."'		
		");
		alert("با موفقیت اضافه شد");
	}
	else
	{
		$db->query("update people_base_wage set 
		start_date='".$_POST['start_date']."',
		end_date='".$_POST['end_date']."',
		base_wage='".$_POST['base_wage']."'		
		where id='".$base_wage_id."'
		");
		alert("با موفقیت ویرایش شد");
	}
	
}
if ($base_wage_id<>"")
{
	$db->query("select * from people_base_wage where id='".$base_wage_id."'");
	$res=$db->result();
	$row=$res[0];
	$start_date=$row['start_date'];
	$end_date=$row['end_date'];
	$base_wage=$row['base_wage'];
}
?>
<form method="post">
<input type="hidden" name="step" value="2">
<table width="60%" class="tables">
<tr><td align="left"><b>تاریخ شروع:</b></td><td><input type="text" name="start_date" value="<?php echo $start_date; ?>"><?php calendar("start_date"); ?></td></tr>
<tr><td align="left"><b>تاریخ پایان:</b></td><td><input type="text" name="end_date" value="<?php echo $end_date; ?>"><?php calendar("end_date"); ?></td></tr>
<tr><td align="left"><b>حقوق پایه:</b></td><td><input type="text" name="base_wage" value="<?php echo $base_wage; ?>"> ریال<td></tr>
<tr><td colspan="2" align="center"><button type="submit">ذخیره</button></td></tr>
</table>
</form>

<table class="tableslistr" border="1">
	<tr class="tablesheader">
		<td>ردیف</td>
		<td>تاریخ شروع</td>
		<td>تاریخ پایان</td>
		<td>حقوق پایه (ریال)</td>
		<td>ویرایش</td>
	</tr>
	<?php
	$db->query("select * from people_base_wage where person_id='".$person_id."'");
	$res=$db->result();
	$i=1;
	foreach($res as $row)
	{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['start_date']; ?></td>
			<td><?php echo $row['end_date']; ?></td>
			<td><?php echo $row['base_wage']; ?></td>
			<td><a href="index.php?pid=settings.people&person_id=<?php echo $person_id; ?>&func=base_wage&base_wage_id=<?php echo $row['id']; ?>"><img src="../images/buttons/edit2.png" border="0"></a></td>    
		</tr>
		<?php
	}
	?>
</table>