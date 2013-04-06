<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 *************************************************************************/

  // INIT
  require "./scripts/init.php";

  for($a = 0; $a < 24; $a++)
  {

    $q = MySQL_query("SELECT kdy, teplota 
                      FROM tme 
                      WHERE kdy >= CAST('{$_GET['jenden']} ".(strlen($a) == 1 ? "0".$a : $a).":00:00' AS datetime) 
                        AND kdy <= CAST('{$_GET['jenden']} ".(strlen($a) == 1 ? "0".$a : $a).":59:59' AS datetime) 
                      ORDER BY kdy ASC 
                      LIMIT 1");

    $t = MySQL_fetch_assoc($q);

    // pridame teplotu do pole
    if($t['teplota'] == ""){ $ydata[] = "0"; }
    else{ $ydata[] = round(jednotkaTeploty($t['teplota'], $u, 0), 1); }
    // pridame popisek do pole
    $labels[] = substr($t['kdy'], 11, 5);

  }

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'graf-historie-teplota', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['teplota']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right' }
            },
            yAxis: [{ 
                labels: {
                    formatter: function() { return this.value +' <?php echo "$jednotka"; ?>'; },
                    style: { color: '#c4423f' }
                },
                title: {
                    text: null
                }
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
                enabled: false
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