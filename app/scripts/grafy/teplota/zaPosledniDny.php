<?php

  // obratime pole
  $ydata = array_reverse($minmax);
  $labels = array_reverse($dny);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        window.chart = new Highcharts.Chart({
        
            chart: { renderTo: 'teplotyZaPosledniDny', type: 'arearange', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0 },
            credits: { enabled: 0 },
            title: { text: null },
            xAxis: {
              categories: ['<?php echo implode("','", $labels); ?>'], 
              labels: { rotation: -45, align: 'right', step: 3 }
            },
            
		    title: {
		        text: 'MIN-MAX'
		    },
		
		    yAxis: {
		        title: {
		            text: null
		        }
		    },
		
		    tooltip: {
		        crosshairs: true,
		        shared: true,
		        valueSuffix: ' <?php echo "$jednotka"; ?>'
		    },
		    
		    legend: {
		        enabled: false
		    },
		
		    series: [{
		        name: '<?php echo $lang['teplota'] ?>',
            color: '#c4423f',
		        data: [ [<?php echo implode("],[", $ydata) ?>] ]
		    }]
		
		});

    $(".tabs > li").click(function () { chart.reflow(); });

    });
    
});
</script>