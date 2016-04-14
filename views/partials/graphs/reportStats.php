<?php
//TODO this should be in the controller not here this is crap but prof of concept
// also this should produce 12 months worth of values for each year including 0s atm im padding older data with 0's massive fudge :/

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
});
</script>
<div id="reportStatsLine" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
<div style="float:right;margin-top: -20px;margin-right: 8px;">
  <span style="font-size: 0.7rem;color: white;background: #BFCC80;padding: 0.1rem 0.5rem;"><?php echo "Total tickets closed in ".date("Y",strtotime("-1 year"));?></span>
  <span style="font-size: 0.7rem;color: white;background: #FFA38B;padding: 0.1rem 0.5rem;"><?php echo "Total ticket closed in ".date("Y") ;?></span>
</div>
