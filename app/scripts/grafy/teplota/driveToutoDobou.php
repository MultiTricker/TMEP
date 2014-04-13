<?php

  // INIT
  require dirname(__FILE__)."/../../init.php";

  // abychom ziskali spravnou posloupnoust udaju, tak pole obratime
  $ydata = array_reverse($teplotaGraf);
  $labels = array_reverse($dnyGraf);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'driveToutoDobou', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb', borderRadius: 0 },
            credits: { enabled: 0 },
            title: { text: null },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 1 }
            },
            yAxis: [{ 
                labels: {
                    formatter: function() { return this.value +' <?php echo "$jednotka"; ?>'; },
                    style: { color: '#c4423f' }
                },
                title: {
                    text: null,
                    style: { color: '#c4423f' }
                },
                opposite: false
            }],
            tooltip: {
                formatter: function() {
                    var unit = {
                        '<?php echo $lang['teplota'] ?>': '<?php echo "$jednotka"; ?>'
                    }[this.series.name];
                    return '<b>'+ this.x +'</b><br /><b>'+ this.y +' '+ unit + '</b>';
                },
                crosshairs: true,
            },
            legend: {
                layout: 'horizontal',
                align: 'left',
                x: 44,
                verticalAlign: 'top',
                y: -5,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                name: '<?php echo $lang['teplota'] ?>',
                type: 'spline',
                color: '#c4423f',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }]
        });
    });
    
});
</script>