<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
$x="";
$date_from="";
$date_to="";

$person_id=$db->mysql_real_escape_string($_GET['person_id']);

if (isset($_GET['date_from']))
{
	$date_from=$db->mysql_real_escape_string($_GET['date_from']);
}
if (isset($_GET['date_to']))
{
	$date_to=$db->mysql_real_escape_string($_GET['date_to']);
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
	<tr class="tablesheader_print">
		<td colspan="6"  style="direction:ltr;">
			از تاریخ: <?php echo date_persian($date_from); ?> <br/>
			تا تاریخ: <?php echo date_persian($date_to); ?>
			<br/>
			<b>نام :</b> 
			<?php
			$db->query("select * from people where id='".$person_id."'");
			$res3=$db->result();
			$row3=$res3[0];
			echo $row3['name'];
			?><br/>
			<b>تاریخ :</b> <?php echo date_persian($today); ?>
		</td>
	</tr>
	<tr class="tablesheader_print">
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
			<td><?php echo number_persian($i++); ?></td>
			<td><?php echo date_persian($row['date']); ?></td>
			<td><?php echo number_persian($row['enter_time']); ?></td>
			<td><?php echo number_persian($row['exit_time']); ?></td>
			<td>
				<?php
				$start_date = new DateTime("0000-00-00 ".$row['enter_time'].":00",new DateTimeZone('Asia/Tehran'));
				$end_date = new DateTime("0000-00-00 ".$row['exit_time'].":00", new DateTimeZone('Asia/Tehran'));
				$interval = $start_date->diff($end_date);
				$hours   = $interval->format('%h'); 
				$minutes = $interval->format('%i');
				echo number_persian($hours.":".$minutes);
				$active_hours+=$hours;
				$active_minutes+=$minutes;
				$active_time=$hours+($minutes/60);
				?>
			</td>
			<td>
				<?php
				echo price_persian($active_time*$row['base_wage']);
				$wage+=$active_time*$row['base_wage'];
				?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr class="tablessum">
		<td colspan="4">جمع کل:</td>
		<td><?php echo number_persian($active_hours); ?></td>
		<td><?php echo price_persian($wage); ?> ریال</td>
		
	</tr>
</table>
