<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <div id="overview">
        <a href="/report/outstanding/">
          <p>
            <span class="overviewValue"><?php echo @$pagedata->opentickets ?></span>
            <span class="overviewLabel">Open tickets</span>
          </p>
        </a>
        <a href="/report/engineerbreakdown/">
          <p>
            <span class="overviewValue"><?php echo @$pagedata->closedtickets ?></span>
            <span class="overviewLabel">Closed tickets</span>
          </p>
        </a>
        <a href="/report/daybreakdown/">
          <p class="fullwidth">
            <span class="overviewValue">
              <script type="text/javascript">
                $(function() {
                  var activityData = {
                    labels: ['7am','8','9','10','11','12','13','14','15','16','17','18','19pm'],
                    series: [ [<?php echo @$pagedata->activity-5 ?>,
                              <?php echo @$pagedata->activity-2 ?>,
                              <?php echo @$pagedata->activity ?>,
                              <?php echo @$pagedata->activity-2 ?>,
                              <?php echo @$pagedata->activity-5 ?>,
                              <?php echo @$pagedata->activity-5 ?>,
                              <?php echo @$pagedata->activity-2 ?>,
                              <?php echo @$pagedata->activity-2 ?>,
                              <?php echo @$pagedata->activity ?>,
                              <?php echo @$pagedata->activity-4 ?>,
                              <?php echo @$pagedata->activity-4 ?>,
                              <?php echo @$pagedata->activity-4 ?>,
                              <?php echo @$pagedata->activity-5 ?>]
                            ]
                  }
                  var activityOptions = {
                    showPoint: true,
                    lineSmooth: true,
                    fullWidth: true,
                    chartPadding: { right: 30, left: 30, bottom: 0 },
                    axisX: { showGrid: false },
                    axisY: { showLabel: false, showGrid: false },
                    low: 0
                  }
                  var activityChart = new Chartist.Line('#activityLine', activityData, activityOptions);
                });
              </script>
              <div id="activityLine" class="ct-chart" style="width: 90%;float: left;"></div>
            </span>
            <span class="overviewLabel" style="clear:both;">Activity</span>
          </p>
        </a>
        <a href="/report/sla/">
          <p style="clear:both;">
            <span class="overviewValue"><?php echo number_format(@$pagedata->firstresponse,0) ?>%</span>
            <span class="overviewLabel">First response</span>
          </p>
        </a>
        <a href="/report/sla/">
          <p>
            <span class="overviewValue"><?php echo number_format(@$pagedata->closetime,0) ?>%</span>
            <span class="overviewLabel">Close time</span>
          </p>
        </a>
        <a href="/report/feedback/">
          <p class="fullwidth">
            <span class="overviewValue"><?php for ($i = 0; $i < round(@$pagedata->avgfeedback); $i++) { echo "<img src='/public/images/ICONS-star.svg' alt='star' height='75' width='auto' />"; } ?></span>
            <span class="overviewLabel">Average feedback</span>
          </p>
        </a>
        <a href="/report/categorybreakdown/">
          <p>
            <span class="overviewValue"><?php echo @$pagedata->topcategory ?></span>
            <span class="overviewLabel">Top category</span>
          </p>
        </a>
        <a href="/report/urgencybreakdown/">
          <p>
            <span class="overviewValue"><?php echo @$pagedata->avgurgency ?></span>
            <span class="overviewLabel">Average urgency</span>
          </p>
        </a>
        </div>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
