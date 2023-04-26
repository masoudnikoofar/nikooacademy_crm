<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php access_check(); ?>
<?php
if ($_POST['step']=="2")
{
    $x="1";
    if ($_POST['date_from']>0)
    {
        $x.=" and invoice_date>='".$_POST['date_from']."'";
    }
    if ($_POST['date_to']>0)
    {
        $x.=" and invoice_date<='".$_POST['date_to']."'";
    }
    ?>
    <table class="tableslistr" width="80%" border="1">
        <tr class="tablesheader">
            <td>ردیف</td>
            <td>نام کالا</td>
            <td>تعداد</td>
        </tr>
        <?php
		/*$db->query("select a.id as good_id,a.name as good_name,count(b.good_id) as count from goods a left join invoices_goods_view b on a.id=b.good_id where $x group by a.id,a.name order by 3 desc");
		*/
		$db->query("select good_id,good_name,count(*) as count from invoices_goods_view where $x group by good_id,good_name order by 3 desc");
        $res=$db->result();
        $i=1;
        foreach ($res as $row)
        {
			$count=$row['count'];
			if ($count==0)
				continue;
            ?>
            <tr>
				<td><?php echo $i++; ?></td>
                <td><?php echo $row['good_name']; ?></td>
                <td><?php echo $count; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
	<br/>
	<script>
$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    
        var chart;
	$(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'نمودار تعداد کالای فروخته شده'
            },
            subtitle: {
                text: 'ss'
            },
            xAxis: {
                categories: [
				<?php
				$db->query("select good_id,good_name,count(*) as count from invoices_goods_view where $x group by good_id,good_name order by 3 desc");
				$res=$db->result();
				foreach ($res as $row)
				{
					echo "'".$row['good_name']."',";
				}
				?>
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'تعداد',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'کالا',
                data: [
				<?php
				$db->query("select good_id,good_name,count(*) as count from invoices_goods_view where $x group by good_id,good_name order by 3 desc");
				$res=$db->result();
				$i=1;
				foreach ($res as $row)
				{
					echo $row['count'].",";
				}
				?>
				]
            }]
        });
    });
});
});
</script>
<div id="container" style="min-width: 310px; min-height: 1000px; margin: 0 auto;direction:ltr"></div>
    <?php  	
}
else
{
?>
    <form method="post">
    <input type="hidden" name="step" value="2">
    <table class="tables" width="50%">
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