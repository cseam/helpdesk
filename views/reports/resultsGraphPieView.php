<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
            <?php
            // parse $pagedata for graph,
            //TODO this should be in the controler not the view idealy
              $labels = $series = "";
              foreach($pagedata->reportResults as $key => $value) {
                $labels .= "\"" .array_values($value)[0] . "\",";
                $series .= array_values($value)[1] . ",";
              }
              $labels = rtrim($labels, ",");
              $series = rtrim($series, ",");
            ?>
            <script type="text/javascript">
            // Draw graph from $lables & $series
            $(function() {
              var data = {
                          labels: [<?php echo $labels ?>],
                          series: [<?php echo $series ?>],
                        };
              var options = {
                            donut: true,
                            chartPadding: 75,
                            donutWidth: 75,
                            labelOffset: 75,
                            labelDirection: 'explode',
                              labelInterpolationFnc: function(value) {
                              return value
                            }
                        };
              new Chartist.Pie('#barChartReport', data, options);
            });
            </script>
            <div id="barChartReport" class="ct-chart ct-minor-second"></div>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
