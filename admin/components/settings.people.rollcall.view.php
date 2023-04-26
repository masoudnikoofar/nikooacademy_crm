<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<a href="index.php?pid=settings.people&func=rollcall&func2=add&person_id=<?php echo $person_id; ?>"><img src="../images/buttons/add.png" border="0"><br/>ورود ساعت حضور غیاب</a>
<hr/>
<?php
if ($_POST['step']=="2")
{
	$x="";
	$date_from="";
	$date_to="";
	
	
	if (isset($_POST['date_from']))
	{
		$date_from=$db->mysql_real_escape_string($_POST['date_from']);
	}
	if (isset($_POST['date_to']))
	{
		$date_to=$db->mysql_real_escape_string($_POST['date_to']);
	}
	
	
	if ($date_from!="")
	{
		$x.=" and date >='".$date_from."'";
	}
	
	if ($date_to!="")
	{
		$x.=" and date <='".$date_to."'";
	}
	
	$db->query("select x.*,y.base_wage from people_rollcall x left join people_base_wage y
	on x.date between y.start_date and y.end_date and x.person_id=y.person_id
	where x.person_id='".$person_id."'".$x." order by x.date");
	$res=$db->result();
	?>
	<table class="tableslistr" border="1" width="100%">
		<tr class="tablesheader">
			<td colspan="8">
				از تاریخ: <?php echo $date_from; ?> 
				تا تاریخ: <?php echo $date_to; ?>
			</td>
		</tr>
		<tr class="tablesheader">
			<td>ردیف</td>
			<td>تاریخ</td>
			<td>ساعت ورود</td>
			<td>ساعت خروچ</td>
			<td>مدت زمان حضور</td>
			<td>حق الزحمه</td>
			<td>ویرایش</td>
			<td>حذف</td>
		</tr>
		<?php
		$i=1;
		$wage=0;
		$active_hours=0;
		$active_minutes=0;
		foreach ($res as $row)
		{
			?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $row['date']; ?></td>
				<td><?php echo $row['enter_time']; ?></td>
				<td><?php echo $row['exit_time']; ?></td>
				<td>
					<?php
					$start_date = new DateTime("0000-00-00 ".$row['enter_time'].":00",new DateTimeZone('Asia/Tehran'));
					$end_date = new DateTime("0000-00-00 ".$row['exit_time'].":00", new DateTimeZone('Asia/Tehran'));
					$interval = $start_date->diff($end_date);
					$hours   = $interval->format('%h'); 
					$minutes = $interval->format('%i');
					echo $hours.":".$minutes;
					$active_hours+=$hours;
					$active_minutes+=$minutes;
					$active_time=$hours+($minutes/60);
					?>
				</td>
				<td>
					<?php
					echo price_english($active_time*$row['base_wage']);
					$wage+=$active_time*$row['base_wage'];
					?>
				</td>
				<td><a href="index.php?pid=settings.people&person_id=<?php echo $person_id; ?>&func=rollcall&rollcall_id=<?php echo $row['id']; ?>&func2=edit"><img src="../images/buttons/edit2.png" border="0"></a></td>    
				
				<td><a href="#" onclick="confirm_delete('<?php echo $row['id']; ?>','index.php?pid=settings.people&person_id=<?php echo $person_id; ?>&func=rollcall&rollcall_id=<?php echo $row['id']; ?>&func2=delete')"><img src="../images/buttons/delete2.png" border="0"></a></td>    
			</tr>
			<?php
		}
		?>
		<tr class="tablessum">
			<td colspan="4">جمع کل:</td>
			<td><?php echo price_english($active_hours); ?></td>
			<td colspan="3"><?php echo price_english($wage); ?></td>
			
		</tr>
	</table>
	<?php
	
}
else
{
?>
	<table class="tables">
		<form method="post">
		<input type="hidden" name="step" value="2">
		<tr>
			<td align="left"><b>از تاریخ:</b></td>
			<td><input type="text" name="date_from"><?php calendar("date_from"); ?></td>
		</tr>
		<tr>
			<td align="left"><b>تا تاریخ:</b></td>
			<td><input type="text" name="date_to"><?php calendar("date_to"); ?></td>
		</tr>
		<tr>
			<td><button type="submit">جستجو</button></td>
		</tr>
		</form>

	</table>
<?php
}
?>