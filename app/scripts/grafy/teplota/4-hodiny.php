<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 *************************************************************************/

  // INIT
  require "./scripts/init.php";

  // Posledni zaznamy
  $q = MySQL_query("SELECT kdy, teplota FROM tme ORDER BY kdy DESC LIMIT 240");

      // budeme pocitat kazdy osmy zaznam, tedy kazdou osmou minutu
      $a = 8;
      $count = 0;

        while($t = MySQL_fetch_assoc($q))
        {

        // budeme pocitat prumernou teplotu za poslednich osm minut... vypada to lepe
        $teplota = $teplota+$t['teplota'];
        $count++;

          if($a == 8)
          {

            // pridame do poli
            if(round($teplota/$count, 1) == 0){ $ydata[] = "0"; }
            else{ $ydata[] = round(jednotkaTeploty($teplota/$count, $u, 0), 1); }
            
            $labels[] = substr($t['kdy'], 11, 5);

            $teplota = "";
            $count = 0;

            $a = 0;      

          }

        $a++;

        }

        // obratime pole
        $ydata = array_reverse($ydata);
        $labels = array_reverse($labels);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'graf-4-hodiny-teplota', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['teplota4hodiny']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 0 }
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