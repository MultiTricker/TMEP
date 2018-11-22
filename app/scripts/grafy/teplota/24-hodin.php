<?php

// INIT
require dirname(__FILE__) . "/../../init.php";;

// Posledni zaznamy
$q = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost 
                                    FROM tme  
                                    WHERE kdy >= NOW() - INTERVAL 1 DAY  
                                    ORDER BY kdy DESC;");

// budeme brat kazdy Xty zaznam, abychom se do grafu rozumne vesli
$a = 10;
$count = 0;
$predchoziTeplota = "";
$delejUpdate = 0;
$zobrazuj = 1;

while($t = MySQLi_fetch_assoc($q))
{
    // budeme za tu dobu pocitat prumernou teplotu,
    // abychom meli graf "uhlazenejsi" (vypada to lepe)
    $teplota = $teplota + $t['teplota'];
    $count++;

    if($predchoziTeplota != "")
    {
        $rozdil = ((strtotime($predchoziTeplota) - time()) - (strtotime($t['kdy']) - time()));
        if($rozdil > 120)
        {
            $delejUpdate = 1;
        }
        else
        {
            $delejUpdate = 0;
        }
        $rozdilOdted = time() - strtotime($t['kdy']);
        if($rozdilOdted > (3600 * 25))
        {
            $zobrazuj = 0;
        }
    }

    // uz mame dostatek mereni?
    if(($a == 10 OR $delejUpdate == 1) AND $zobrazuj == 1)
    {
        // pridame teplotu do pole
        if(round($teplota / $count, 1) == 0)
        {
            $ydata[] = jednotkaTeploty(0, $u, 0);
        }
        else
        {
            $ydata[] = round(jednotkaTeploty($teplota / $count, $u, 0), 1);
        }
        // pridame popisek do pole
        $labels[] = $t['kdy'];

        // "vynulujeme" teplotu
        $teplota = "";
        // vynulujeme pocitadla
        $count = 0;

        $delejUpdate = 0;

        $a = 0;
    }

    // iterujeme
    $a++;

    $predchoziTeplota = $t['kdy'];
}

// abychom ziskali spravnou posloupnoust udaju, tak obe pole obratime
$ydata = array_reverse($ydata);
$labels = array_reverse($labels);

$mereni = 0;
$plotLines = [];
$latestLabel = "";

foreach($labels as $index => $label)
{
    if((substr($label, 0, 10) != substr($latestLabel, 0, 10)) AND $latestLabel != "")
    {
        $plotLines[] = $mereni;
    }
    $latestLabel = $label;
    $labels[$index] = substr($label, 11, 5);
    $mereni++;
}

$plotLinesOutput = "";
if(count($plotLines) > 0)
{
    $toOutput = [];

    foreach($plotLines AS $position)
    {
        $toOutput[] = "{ color: 'lightgrey', dashStyle: 'solid', value: {$position}, width: 1 }";
    }

    $plotLinesOutput = implode(",", $toOutput);
}

?>
<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function () {
            chart = new Highcharts.Chart({
                chart: {renderTo: 'graf-24-hodin-teplota', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0},
                credits: {enabled: 0},
                title: {text: '<?php echo $lang['teplota24hodin']; ?>'},
                xAxis: {
                    categories: ['<?php echo implode("','", $labels); ?>'],
                    labels: {rotation: -45, align: 'right', step: 4},
                    plotLines: [<?php echo $plotLinesOutput; ?>]
                },
                yAxis: [{
                    labels: {
                        formatter: function () {
                            return this.value + ' <?php echo "$jednotka"; ?>';
                        },
                        style: {color: '#c4423f'}
                    },
                    title: {
                        text: null,
                        style: {color: '#c4423f'}
                    },
                    opposite: false
                }],
                tooltip: {
                    formatter: function () {
                        var unit = {
                            '<?php echo $lang['teplota'] ?>': '<?php echo "$jednotka"; ?>',
                        }[this.series.name];
                        return '<b>' + this.x + '</b><br /><b>' + this.y + ' ' + unit + '</b>';
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
                    marker: {enabled: false}
                }]
            });

            $(".tabs > li").click(function () {
                chart.reflow();
            });

        });

    });
</script>