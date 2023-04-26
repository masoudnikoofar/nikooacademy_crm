<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST['step']=="2")
{
	$x="";

	
	if (isset($_POST['month']))
	{
		$month=$db->mysql_real_escape_string($_POST['month']);
		$x.=" and left(date,7) ='".$month."'";
	}
	
	$db->query("select x.*,y.base_wage from people_rollcall x left join people_base_wage y
	on x.date between y.start_date and y.end_date and x.person_id=y.person_id
	where x.person_id='".$person_id."'".$x." order by x.date");


	$res=$db->result();
	?>
	<table class="tableslistr" border="1" width="100%">
		<tr class="tablesheader">
			<td colspan="8">
				ماه: <?php echo $_POST['month']; ?> 
				<a href="index.php?pid=settings.people&person_id=<?php echo $person_id; ?>&func=payments&func2=print&month=<?php echo $month; ?>"><img src="../images/buttons/print_small.png" border="0">
				<a href="index.php?pid=settings.people&person_id=<?php echo $person_id; ?>&func=payments&func2=extra_info&month=<?php echo $month;?>"><img src="../images/buttons/add2.png" border="0"></a>
			</td>
		</tr>
		<tr class="tablesheader">
			<td>ردیف</td>
			<td>تاریخ</td>
			<td>ساعت ورود</td>
			<td>ساعت خروچ</td>
			<td>مدت زمان حضور</td>
			<td>حق الزحمه</td>
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
	$db->query("select * from people_payments where 
	person_id='".$person_id."' and
	month='".$month."'
	");
	$res=$db->result();
	$row=$res[0];
	?>
	<table width="100%" class="tableslistr" border="1">
		<tr>
			<td><b>تاریخ پرداخت:</b><?php echo $row['payment_date']; ?></td>
		</tr>
		<tr>
			<td>
				<b>نوع پرداخت:</b>
				<?php 
				if ($row['payment_type']=="1") echo "نقدی";
				else if ($row['payment_type']=="2") echo "انتقال وجه کارت به کارت"; 
				?>
			</td>
		</tr>
		<?php
		if ($row['payment_type']=="2")
		{
		?>
			<tr>
				<td><b>شماره حواله:</b><?php echo $row['payment_info']; ?></td>
			</tr>
		<?php
		}
		?>
		<?php
		if ($row['comment']!="")
		{
		?>
			<tr>
				<td><b>توضیحات:</b><?php echo $row['comment']; ?></td>
			</tr>
		<?php
		}
		?>
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
			<td align="left"><b>سال-ماه:</b></td>
			<td><input type="text" name="month">(مثال: yyyy-mm)</td>
		</tr>
		<tr>
			<td><button type="submit">جستجو</button></td>
		</tr>
		</form>
	</table>
	<?php
}
?>