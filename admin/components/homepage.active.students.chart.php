<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<script>
$(function () {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        $('#container01').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'وضعیت دانشجوها'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y + ' نفر <br/>'; // + this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'وضعیت',
                data: [
                    <?php
					$db->query("select if(inactive=1,'غیرفعال','فعال') as status,count(*) as count from students group by if(inactive=1,'غیرفعال','فعال')");
					$res=$db->result();
					foreach ($res as $row)
					{
						?>
						['<?php echo $row['status']; ?>',<?php echo $row['count']; ?>],
						<?php
					}
					
					?>
                ]
            }]
        });
    });
</script>

<script>
$(function () {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        $('#container02').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'وضعیت دوره ها'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y + ' دوره <br/>'; // + this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'وضعیت',
                data: [
                    <?php
					$db->query("select if(inactive=1,'غیرفعال','فعال') as status,count(*) as count from students_courses group by if(inactive=1,'غیرفعال','فعال')");
					$res=$db->result();
					foreach ($res as $row)
					{
						?>
						['<?php echo $row['status']; ?>',<?php echo $row['count']; ?>],
						<?php
					}
					
					?>
                ]
            }]
        });
    });
</script>

<div id="container01" style="direction: ltr; min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="container02" style="direction: ltr; min-width: 310px; height: 400px; margin: 0 auto"></div>