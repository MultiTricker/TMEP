<?php

// INIT
require dirname(__FILE__) . "/../../init.php";

// abychom ziskali spravnou posloupnoust udaju, tak pole obratime
$ydata = array_reverse($teplotaGraf);
$ydata2 = array_reverse($vlhkostGraf);
$ydata3 = array_reverse($rosnyBodGraf);
$labels = array_reverse($dnyGraf);

?>
<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function () {
            chart = new Highcharts.Chart({
                chart: {renderTo: 'driveToutoDobou', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0},
                credits: {enabled: 0},
                title: {text: null},
                xAxis: {
                    categories: ['<?php echo implode("','", $labels); ?>'],
                    labels: {rotation: -45, align: 'right', step: 1}
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
                }, {
                    gridLineWidth: 0,
                    title: {
                        text: null,
                        style: {color: '#4572a7'}
                    },
                    labels: {
                        formatter: function () {
                            return this.value + ' %';
                        },
                        style: {color: '#4572a7'},
                        max: 100
                    },
                    opposite: true
                }, {
                    gridLineWidth: 0,
                    title: {
                        text: null,
                        style: {color: '#6ba54e'}
                    },
                    labels: {
                        formatter: function () {
                            return this.value + ' <?php echo "$jednotka"; ?>';
                        },
                        style: {color: '#6ba54e'}
                    },
                    opposite: true
                }],
                tooltip: {
                    formatter: function () {
                        var unit = {
                            '<?php echo $lang['teplota'] ?>': '<?php echo "$jednotka"; ?>',
                            '<?php echo $lang['vlhkost'] ?>': '%',
                            '<?php echo $lang['rosnybod'] ?>': '<?php echo "$jednotka"; ?>'
                        }[this.series.name];
                        return '<b>' + this.x + '</b><br /><b>' + this.y + ' ' + unit + '</b>';
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
                    marker: {enabled: false}
                }, {
                    name: '<?php echo $lang['vlhkost'] ?>',
                    type: 'spline',
                    color: '#4572a7',
                    yAxis: 1,
                    data: [<?php echo implode(", ", $ydata2); ?>],
                    marker: {enabled: false}
                }, {
                    name: '<?php echo $lang['rosnybod'] ?>',
                    type: 'spline',
                    color: '#6ba54e',
                    yAxis: 2,
                    data: [<?php echo implode(", ", $ydata3); ?>],
                    marker: {enabled: false},
                    visible: false
                }]
            });

            $(".tabs > li").click(function () {
                chart.reflow();
            });

        });

    });
</script>