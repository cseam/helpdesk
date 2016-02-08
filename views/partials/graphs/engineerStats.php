<script type="text/javascript">
  $(function() {
    // WAIT FOR DOM
    // Draw Pie chartist.js
    var pieData = {
                  series: [<?php echo $stats["totalTickets"];?>,<?php echo $stats["totalTicketsByHelpdesk"];?>]
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
                        [0,40,21,30,2,10,0],
                        [0,10,44,33,12,100,0],
                        [0,22,24,3,22,15,0],
                        [0,44,0,40,44,10,0],
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
<span style="display:table-cell; vertical-align: middle; text-align: center; font-size: 2.5rem;font-weight: 100;">
<?php
  $engineernum = $stats["totalTicketsByHelpdesk"];
  $totaltickets = $stats["totalTickets"];
  echo number_format((100.0*$engineernum)/$totaltickets, 2) . "%";
?>
</span>
</div>
<div id="weekstats" class="ct-chart ct-golden-section" style="width: 60%; height: 85%;float:left;"></div>
