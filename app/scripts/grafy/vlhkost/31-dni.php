<?php

  // INIT
  require dirname(__FILE__)."/../../init.php";

  // maximalni teplota dany den
  $qj = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejvyssi_vlhkost, nejnizsi_vlhkost, prumer_vlhkost FROM tme_denni ORDER BY den DESC LIMIT 0, 31");
  while($hod = MySQLi_fetch_assoc($qj))
  {
    // popisek
    $labels[] = formatDnu($hod['den']);
    // sup do pole
    if(round($hod['nejvyssi_vlhkost'], 2) == 0){ $ydata[] = "0"; }
    else
    { $ydata[] = round($hod['nejvyssi_vlhkost'],2); }

    if(round($hod['nejnizsi_vlhkost'], 2) == 0){ $ydata2[] = "0"; }
    else
    { $ydata2[] = round($hod['nejnizsi_vlhkost'],2); }

    if(round($hod['prumer_vlhkost'], 2) == 0){ $ydata3[] = "0"; }
    else
    { $ydata3[] = round($hod['prumer_vlhkost'],2); }

  }

  // obratime pole
  $ydata = array_reverse($ydata);
  $ydata2 = array_reverse($ydata2);
  $ydata3 = array_reverse($ydata3);
  $labels = array_reverse($labels);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'graf-31-dni-vlhkost', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0 },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['vlhkost31dni']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right' }
            },
            yAxis: [{ 
                labels: {
                    formatter: function() { return this.value +' %'; },
                    style: { color: '#1260c0' }
                },
                title: {
                    text: null,
                    style: { color: '#1260c0' }
                },
                opposite: false,
                max: 100
            }],
            tooltip: {
                formatter: function() {
                    var unit = {
                        '<?php echo $lang['max'] ?>': ' %',
                        '<?php echo $lang['avg'] ?>': ' %',
                        '<?php echo $lang['min'] ?>': ' %'
                    }[this.series.name];
                    return '<b>'+ this.x +'</b><br /><b>'+ this.y +' '+ unit + '</b>';
                },
                crosshairs: true,
            },
            legend: {
                layout: 'horizontal',
                align: 'left',
                x: 6,
                verticalAlign: 'top',
                y: -5,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                name: '<?php echo $lang['max'] ?>',
                type: 'spline',
                color: '#294d9f',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }, {
                name: '<?php echo $lang['avg'] ?>',
                type: 'spline',
                color: '#7993cd',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata3); ?>],
                marker: { enabled: false }
    
            }, {
                name: '<?php echo $lang['min'] ?>',
                type: 'spline',
                color: '#becced',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata2); ?>],
                marker: { enabled: false }
            }]
        });

    $(".tabs > li").click(function () { chart.reflow(); });

    });
    
});
</script>