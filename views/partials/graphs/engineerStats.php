<script type="text/javascript">
  $(function() {
    // WAIT FOR DOM
    // Draw Pie chartist.js
    var pieData = {
                  series: [<?php echo $stats["engineerClose"] ?>,<?php echo $stats["engineerAll"]-$stats["engineerClose"] ?>]
    };
    var pieOptions = {
                      chartPadding: {top: 20, right:5, bottom:20, left:5},
                      donut: true,
                      showLabel: false,
                      donutWidth: 25
    };
    new Chartist.Pie('#myperformance', pieData, pieOptions);

    // Draw Bar chartist.js
    var data = {
                labels: ['Su','Mo','Tu','We','Th','Fr','Sa'],
                series: [
                        [<?php echo $stats["Sun"] ?>,<?php echo $stats["Mon"] ?>,<?php echo $stats["Tue"] ?>,<?php echo $stats["Wed"] ?>,<?php echo $stats["Thu"] ?>,<?php echo $stats["Fri"] ?>,<?php echo $stats["Sat"] ?>],
                        ]
    };
    var options = {
                  showPoint: true,
                  lineSmooth: false,
                  fullWidth: true,
                  chartPadding: { right: 20, left: 10, bottom: 10 },
                  axisX: { showGrid: false },
                  axisY: { showLabel: true, onlyInteger: true }
    };

    var chart = new Chartist.Line('#weekstats', data, options);
    chart.on('draw', function(data) {
      if(data.type === 'line' || data.type === 'area') {
        data.element.animate({
          d: {
            begin: 500 * data.index,
            dur: 2000,
            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
            to: data.path.clone().stringify(),
            easing: Chartist.Svg.Easing.easeOutQuint
          }
        });
      }
    });
});
</script>

<div id="myperformance" class="ct-chart ct-perfect-fourth" style="width:40%; height:85%; float: left; display:table;">
<span style="display:table-cell; vertical-align: middle; text-align: center; font-size: 1.8rem;font-weight: 100;">
<?php
  $engineernum = $stats["engineerClose"];
  $totaltickets = $stats["engineerAll"];
  echo number_format((100.0*$engineernum)/$totaltickets, 2) . "%";
?>
</span>
</div>
<div id="weekstats" class="ct-chart ct-golden-section" style="width: 60%; height: 85%;float:left;"></div>
