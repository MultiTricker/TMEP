<?php

  // INIT
  require dirname(__FILE__)."/../../init.php";

  $od = Array();
  $do = Array();
  // posledni dny do pole
  $dny2 = Array();
  $od = date("Y-m-d H:00:00", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-3, date("Y")));
  $do = date("Y-m-d H:m:s");

  $tep = 0;

  // Posledni zaznamy
  $q = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota
                                        FROM tme
                                        WHERE kdy >= CAST('{$od}' AS datetime)
                                          AND kdy <= CAST('{$do}' AS datetime)
                                        ORDER BY kdy DESC");
      $a = 12;
      $fr = 1;
        while($t = MySQLi_fetch_assoc($q))
        {
          $tep = $tep+$t['teplota'];
          if($a == 12)
          {

            $labels[] = substr($t['kdy'], 11, 5);

            if($tep == 0 OR ($tep/12) == 0){ $ydata[] = jednotkaTeploty(0, $u, 0); }

            $a = 0;
            if($fr == 1)
            {
            $fr = 0;
            $ydata[] = jednotkaTeploty($tep, $u, 0);
            }
            else
            {

              if($tep == 0 OR ($tep/12) == 0){ $ydata[] = jednotkaTeploty(0, $u, 0); }
              else
              { $ydata[] = jednotkaTeploty($tep/12, $u, 0); }

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
            chart: { renderTo: 'graf-3-dny-teplota', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['teplota3dny']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 15 }
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