<?php
  $engineernum = $left->sideData["graphdata"]["engineerClose"];
  $totaltickets = $left->sideData["graphdata"]["engineerAll"];
  $engineercalc = $left->sideData["graphdata"]["engineerAll"]-$left->sideData["graphdata"]["engineerClose"];
  $ticketsleft = ($left->sideData["graphdata"]["engineerAll"]-$left->sideData["graphdata"]["engineerClose"] < 0) ? 0 : $engineercalc ;
?>
<script type="text/javascript">
  $(function() {
    // WAIT FOR DOM
    // Draw Pie chartist.js
    var pieData = {
                  series: [<?php echo $engineernum ?>,<?php echo $ticketsleft ?>]
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
                        [
                          <?php echo $left->sideData["graphdata"]["Sun"] ?>,
                          <?php echo $left->sideData["graphdata"]["Mon"] ?>,
                          <?php echo $left->sideData["graphdata"]["Tue"] ?>,
                          <?php echo $left->sideData["graphdata"]["Wed"] ?>,
                          <?php echo $left->sideData["graphdata"]["Thu"] ?>,
                          <?php echo $left->sideData["graphdata"]["Fri"] ?>,
                          <?php echo $left->sideData["graphdata"]["Sat"] ?>,
                        ],
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
<span style="display:table-cell; vertical-align: middle; text-align: center; font-size: 1.5rem;font-weight: 100;">
<?php echo number_format(($engineernum / $totaltickets ) * 100 ,2) ."%"; ?>
</span>
</div>
<div id="weekstats" class="ct-chart ct-golden-section" style="width: 60%; height: 85%;float:left;"></div>
