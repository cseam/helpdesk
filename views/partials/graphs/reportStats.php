<?php
//TODO this should be in the controller not here this is crap but prof of concept
    $series = $temp = "";

    $currentYear = $statsModel->countTotalsThisYear(2016);
    foreach($currentYear as $key => $value) {
      $temp .= $value["Totals"] . ",";
    }
    $temp = rtrim($temp, ",");
    $currentSeries = "[". $temp ."],";

    $temp = "";
    $preYear = $statsModel->countTotalsThisYear(2015);
    foreach($preYear as $key => $value) {
      $temp .= $value["Totals"] . ",";
    }
    $temp = rtrim($temp, ",");
    $preSeries = "[0,0,0,". $temp ."],";
?>

<script type="text/javascript">
  $(function() {
    // Draw Bar chartist.js
    var data = {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                series: [
                        <?php echo $preSeries ?>
                        <?php echo $currentSeries ?>
                        ]
    };
    var options = {
                  showPoint: true,
                  lineSmooth: true,
                  fullWidth: true,
                  chartPadding: { right: 20, left: 10, bottom: 10 },
                  axisX: { showGrid: false },
                  axisY: { showLabel: true },
                  low: 0
    };

    var chart = new Chartist.Line('#reportStatsLine', data, options);
    chart.on('draw', function(data) {
      if(data.type === 'line' || data.type === 'area') {
        data.element.animate({
          d: {
            begin: 100 * data.index,
            dur: 500,
            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
            to: data.path.clone().stringify(),
            easing: Chartist.Svg.Easing.easeOutQuint
          }
        });
      }
    });
});
</script>
<div id="reportStatsLine" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
