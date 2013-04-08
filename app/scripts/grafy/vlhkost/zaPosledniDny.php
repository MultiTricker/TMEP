<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 *************************************************************************/

  // obratime pole
  $ydata = array_reverse($minmax);
  $labels = array_reverse($dny);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        window.chart = new Highcharts.Chart({
        
            chart: { renderTo: 'vlhkostZaPosledniDny', type: 'arearange', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
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
		        valueSuffix: ' %'
		    },
		    
		    legend: {
		        enabled: false
		    },
		
		    series: [{
		        name: '<?php echo $lang['vlhkost'] ?>',
            color: '#4572a7',
		        data: [ [<?php echo implode("],[", $ydata) ?>] ]
		    }]
		
		});
    });
    
});
</script>