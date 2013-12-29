<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 *************************************************************************/

  // INIT
  require "./scripts/init.php";

  $od = Array();
  $do = Array();
  // posledni dny do pole
  $dny2 = Array();
  $od = date("Y-m-d H:00:00", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-3, date("Y")));
  $do = date("Y-m-d H:m:s");

  $tep = 0;

  // Posledni zaznamy
  $q = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, vlhkost FROM tme WHERE kdy > '{$od}' AND kdy < '{$do}' ORDER BY kdy DESC");
      $a = 5;
      $fr = 1;
        while($t = MySQLi_fetch_assoc($q))
        {
          $tep = $tep+$t['vlhkost'];
          if($a == 5)
          {

            $labels[] = substr($t['kdy'], 11, 5);

            if($tep == 0 OR ($tep/5) == 0){ $tep = "0"; }

            $a = 0;
            if($fr == 1)
            {
            $fr = 0;
            $ydata[] = jednotkaTeploty($tep, $u, 0);
            }
            else
            {

              if($tep == 0 OR ($tep/5) == 0){ $ydata[] = "0"; }
              else
              { $ydata[] = jednotkaTeploty($tep/5, $u, 0); }

            }
            
            $tep = 0;
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
            chart: { renderTo: 'graf-3-dny-vlhkost', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['vlhkost3dny']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 15 }
            },
            yAxis: [{ 
                labels: {
                    formatter: function() { return this.value +' <?php echo "$jednotka"; ?>'; },
                    style: { color: '#4572a7' }
                },
                title: {
                    text: null
                }
            }],
            tooltip: {
                formatter: function() {
                    var unit = {
                        '<?php echo $lang['vlhkost'] ?>': '<?php echo "$jednotka"; ?>'
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
                name: '<?php echo $lang['vlhkost'] ?>',
                type: 'spline',
                color: '#4572a7',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }]
        });
    });
    
});
</script>