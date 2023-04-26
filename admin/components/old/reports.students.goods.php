<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>
<?php
if ($_POST[step]=="2")
{
    $x="1";
    
    if ($_POST[good_id]!="")
    {
        $x.=" and good_id='$_POST[good_id]'";
    }
    if ($_POST[date_from]>0)
    {
        $x.=" and invoice_date>='$_POST[date_from]'";
    }
    if ($_POST[date_to]>0)
    {
        $x.=" and invoice_date<='$_POST[date_to]'";
    }
    
    ?>
    <table class="tableslistr" width="80%" border="1">
        <tr class="tablesheader">
            <td>ردیف</td>
            <td>نام هنرچو</td>
            <td>نام کالا</td>
            <td>تاریخ فروش</td>
            <td>تعداد</td>
            <td>قیمت</td>
        </tr>
        <?php
		$db->query("select * from students_goods_view where $x");
        $res=$db->result();
        $i=1;
		$sum_count=0;
		$sum_price=0;
        foreach ($res as $row)
        {
			$good_number=$row['good_number'];
			$total_price=$row['total_price'];
			$toll=$row['toll'];
			$tax=$row['tax'];
            ?>
            <tr>
				<td><?php echo $i++; ?></td>
				
				<td><a href="index.php?pid=students&student_id=<?php echo $row['student_id']; ?>&func=courses" target="_blank"><?php echo $row['student_firstname']." ".$row['student_lastname']; ?> (<?php echo $row['student_id']; ?>)</a></td>
                <td><?php echo $row['good_name']; ?></td>
                <td><?php echo $row['invoice_date']; ?></td>
                <td><?php echo $good_number; ?></td>
				<td><?php echo price_english($total_price); ?></td>
				<?php
				$sum_count+=$good_number;
				$sum_price+=$total_price;
				$sum_toll+=$toll;
				$sum_tax+=$tax;
				?>
            </tr>
            <?php
        }
        ?>
		<tr class="tablesheader">
			<td colspan="4" rowspan="2">جمع کل</td>
			<td><?php echo $sum_count; ?></td>
			<td><?php echo price_english($sum_price); ?></td>
		</tr>
		<tr class="tablesheader">
			<td colspan="3"><?php echo price_english($sum_price+$sum_toll+$sum_tax); ?></td>
		</tr>
		
    </table>
	<br/>
<?php
}
else
{
?>
    <form method="post">
    <input type="hidden" name="step" value="2">
    <table class="tables" width="50%">
        <tr>
            <td align="left"><b>کالا:</b></td>
            <td>
                <select name="good_id">
					<option value="">--انتخاب--</option>
					<?php
					$db->query("Select * from goods where is_old=0 order by name");
					$res=$db->result();
					foreach ($res as $row)
					{
						echo "<option value='$row[id]'>$row[name]</option>";
					}
					?>
					<option value="">--کالاهای قدیمی--</option>
					<?php
					$db->query("Select * from goods where is_old=1 order by name");
					$res=$db->result();
					foreach ($res as $row)
					{
						echo "<option value='$row[id]'>$row[name]</option>";
					}
					?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td align="left"><b>از تاریخ:</b></td>
            <td><input type="text" name="date_from"><?php calendar("date_from"); ?></td>
        </tr>
        <tr>
            <td align="left"><b>تا تاریخ:</b></td>
            <td><input type="text" name="date_to"><?php calendar("date_to"); ?></td>
        </tr>
        <tr><td colspan="2" align="center"><button type="submit">جستجو</button></td></tr>
    </table>
<?php
}
?>