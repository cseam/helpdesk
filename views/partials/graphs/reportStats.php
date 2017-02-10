<?php
  //TODO this should be in the controller not here this is clown fiesta!
  $ticketModel = new ticketModel();
    //work out numbers for current year.
    $series = $temp = "";
    $currentYear = $ticketModel->countTotalsThisYear(date("Y"));
    foreach ($currentYear as $key => $value) {
      $temp .= $value["Totals"].",";
    }
    $temp = rtrim($temp, ",");
    $currentSeries = "[".$temp."],";

    //work out numbers for previous year and pad with 0s if less than years data
    $temp = "";
    $preYear = $ticketModel->countTotalsThisYear(date("Y") - 1);
    foreach ($preYear as $key => $value) {
      $temp .= $value["Totals"].",";
    }
    $temp = rtrim($temp, ",");

    $temp = explode(",", $temp);
    $size = sizeof($temp);
    $padcount = 12 - $size;
    for ($i = 1; $i <= $padcount; $i++) {
      array_unshift($temp, 0);
    }
    $preSeries = "[".implode(",", $temp)."],";

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
  <span style="font-size: 0.7rem;color: white;background: #BFCC80;padding: 0.1rem 0.5rem;"><?php echo "Total tickets (All Helpdesks) closed in ".date("Y", strtotime("-1 year")); ?></span>
  <span style="font-size: 0.7rem;color: white;background: #FFA38B;padding: 0.1rem 0.5rem;"><?php echo "Total ticket (All Helpdesks) closed in ".date("Y"); ?></span>
</div>
