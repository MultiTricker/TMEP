<?php

  // INIT
  require dirname(__FILE__)."/../../init.php";

  $od = Array();
  $do = Array();
  // posledni dny do pole
  $dny2 = Array();
  $od = date("Y-m-d H:00:00", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-3, date("Y")));
  $do = date("Y-m-d H:m:s");

  // Posledni zaznamy vcera
  $q = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost
                                      FROM tme
                                      WHERE kdy >= CAST('{$od}' AS datetime)
                                        AND kdy <= CAST('{$do}' AS datetime)
                                      ORDER BY kdy DESC");

  // budeme brat kazdy 5ty zaznam
  $a = 12;

    while($t = MySQLi_fetch_assoc($q))
    {

    // budeme za tu dobu, aktualne 10 minut, pocitat prumernou teplotu,
    // abychom meli graf "uhlazenejsi" (vypada to lepe)
    $teplota = $teplota+$t['teplota'];
    $vlhkost = $vlhkost+$t['vlhkost'];
    $rosnyBod = $rosnyBod+rosnybod($t['teplota'], $t['vlhkost']);
    $count++;

      // uz mame dostatek mereni?
      if($a == 12)
      {

        // pridame teplotu do pole
        $ydata[] = round(jednotkaTeploty($teplota/$count, $u, 0), 1);
        $ydata2[] = round($vlhkost/$count, 1);
        $ydata3[] = round($rosnyBod/$count, 1);

        // pridame popisek do pole
        $labels[] = substr($t['kdy'], 11, 5);

        // "vynulujeme" teplotu
        $teplota = "";
        $vlhkost = "";
        $rosnyBod = "";
        // vynulujeme pocitadla
        $count = 0;
        $a = 0;      

      }

  // iterujeme
  $a++;

  }

  // abychom ziskali spravnou posloupnoust udaju, tak obe pole obratime
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
            chart: { renderTo: 'graf-3-dny', zoomType: 'x', borderWidth: 1, backgroundColor: '#f7f6eb' },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['3dny']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 12 }
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
            }, {
                gridLineWidth: 0,
                title: {
                    text: null,
                    style: { color: '#4572a7' }
                },
                labels: {
                    formatter: function() { return this.value +' %'; },
                    style: { color: '#4572a7' }
                },
                opposite: true,
                max: 100
            }, {
                gridLineWidth: 0,
                title: {
                    text: null,
                    style: { color: '#6ba54e' }
                },
                labels: {
                    formatter: function() { return this.value +' <?php echo "$jednotka"; ?>'; },
                    style: { color: '#6ba54e' }
                },
                opposite: true
            }],
            tooltip: {
                formatter: function() {
                    var unit = {
                        '<?php echo $lang['teplota'] ?>': '<?php echo "$jednotka"; ?>',
                        '<?php echo $lang['vlhkost'] ?>': '%',
                        '<?php echo $lang['rosnybod'] ?>': '<?php echo "$jednotka"; ?>'
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
                name: '<?php echo $lang['teplota'] ?>',
                type: 'spline',
                color: '#c4423f',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }, {
                name: '<?php echo $lang['vlhkost'] ?>',
                type: 'spline',
                color: '#4572a7',
                yAxis: 1,
                data: [<?php echo implode(", ", $ydata2); ?>],
                marker: { enabled: false }
    
            }, {
                name: '<?php echo $lang['rosnybod'] ?>',
                type: 'spline',
                color: '#6ba54e',
                yAxis: 2,
                data: [<?php echo implode(", ", $ydata3); ?>],
                marker: { enabled: false },
                visible: false
            }]
        });
    });
    
});
</script>