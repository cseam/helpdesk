<script type="text/javascript">
  $(function() {
    // WAIT FOR DOM
    // Draw Pie chartist.js
    var pieData = {
                  series: [<?php echo $stats["total"];?>,<?php echo $stats["total"];?>]
    };
    var pieOptions = {
                      chartPadding: {top: 20, right:5, bottom:20, left:5},
                      donut: true,
                      showLabel: false,
                      donutWidth: 40
    };
    new Chartist.Pie('#myperformance', pieData, pieOptions);

    // Draw Bar chartist.js
    var data = {
                labels: ['Su','Mo','Tu','We','Th','Fr','Sa'],
                series: [
                        [0,40,20,30,2,10,0],
                        [0,5,10,50,5,7,11]
                        ]
    };
    var options = {
                  showPoint: true,
                  lineSmooth: true,
                  fullWidth: true,
                  chartPadding: { right: 20, left: 10, bottom: 10 },
                  axisX: { showGrid: false },
                  axisY: { showLabel: false }
    };

    var chart = new Chartist.Line('#weekstats', data, options);
    chart.on('draw', function(data) {
      if(data.type === 'line' || data.type === 'area') {
        data.element.animate({
          d: {
            begin: 2000 * data.index,
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
<span style="display:table-cell; vertical-align: middle; text-align: center; font-size: 2.5rem;font-weight: 100;">
<?php
if ($allpie > 0) {
$alltotal = $allpie + $allopen;
$display = round(($allpie / $alltotal) * 100);
} else {
$display = '0';
}
echo $display;
?>%
</span>
</div>
<div id="weekstats" class="ct-chart ct-golden-section" style="width: 60%; height: 85%;float:left;"></div>
