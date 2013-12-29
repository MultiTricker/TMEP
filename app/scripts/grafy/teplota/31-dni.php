<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 *************************************************************************/

  // INIT
  require "./scripts/init.php";

  // maximalni teplota dany den
  $qj = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejvyssi, nejnizsi, prumer FROM tme_denni ORDER BY den DESC LIMIT 0, 31");
  while($hod = MySQLi_fetch_assoc($qj))
  {
    // popisek
    $labels[] = formatDnu($hod['den']);
    // sup do pole
    if(round($hod['nejvyssi'], 2) == 0){ $ydata[] = "0"; }
    else
    { $ydata[] = jednotkaTeploty(round($hod['nejvyssi'],2), $u, 0); }

    if(round($hod['nejnizsi'], 2) == 0){ $ydata2[] = "0"; }
    else
    { $ydata2[] = jednotkaTeploty(round($hod['nejnizsi'],2), $u, 0); }

    if(round($hod['prumer'], 2) == 0){ $ydata3[] = "0"; }
    else
    { $ydata3[] = jednotkaTeploty(round($hod['prumer'],2), $u, 0); }

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
            chart: { renderTo: 'graf-31-dni-teplota', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['teploty31dni']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right' }
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
                        '<?php echo $lang['max'] ?>': ' <?php echo "$jednotka"; ?>',
                        '<?php echo $lang['avg'] ?>': ' <?php echo "$jednotka"; ?>',
                        '<?php echo $lang['min'] ?>': ' <?php echo "$jednotka"; ?>'
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
                color: '#c01212',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }, {
                name: '<?php echo $lang['avg'] ?>',
                type: 'spline',
                color: '#ebb91f',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata3); ?>],
                marker: { enabled: false }
    
            }, {
                name: '<?php echo $lang['min'] ?>',
                type: 'spline',
                color: '#1260c0',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata2); ?>],
                marker: { enabled: false }
            }]
        });
    });
    
});
</script>