<?php

// INIT
require dirname(__FILE__) . "/../../init.php";

$od = [];
$do = [];
// posledni dny do pole
$dny2 = [];
$od = date("Y-m-d H:00:00", mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 3, date("Y")));
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
    $tep = $tep + $t['teplota'];
    if($a == 12)
    {

        $labels[] = $t['kdy'];

        if($tep == 0 OR ($tep / 12) == 0)
        {
            $ydata[] = round(jednotkaTeploty(0, $u, 0), 1);
        }

        $a = 0;
        if($fr == 1)
        {
            $fr = 0;
            $ydata[] = round(jednotkaTeploty($tep, $u, 0), 1);
        }
        else
        {

            if($tep == 0 OR ($tep / 12) == 0)
            {
                $ydata[] = round(jednotkaTeploty(0, $u, 0), 1);
            }
            else
            {
                $ydata[] = round(jednotkaTeploty($tep / 12, $u, 0), 1);
            }

        }

        $tep = 0;
    }
    $a++;
}

// obratime pole
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
                chart: {renderTo: 'graf-3-dny-teplota', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0},
                credits: {enabled: 0},
                title: {text: '<?php echo $lang['teplota3dny']; ?>'},
                xAxis: {
                    categories: ['<?php echo implode("','", $labels); ?>'],
                    labels: {rotation: -45, align: 'right', step: 12},
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
                        text: null
                    }
                }],
                tooltip: {
                    formatter: function () {
                        var unit = {
                            '<?php echo $lang['teplota'] ?>': '<?php echo "$jednotka"; ?>'
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
