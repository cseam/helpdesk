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
            <span class="overviewValue"><?php echo number_format(@$pagedata->opentickets["outstanding"],0) ?></span>
            <span class="overviewLabel">Open tickets</span>
          </p>
        </a>
        <a href="/report/engineerbreakdown/">
          <p>
            <span class="overviewValue"><?php echo number_format(@$pagedata->closedtickets["countClosed"],0) ?></span>
            <span class="overviewLabel">Closed tickets</span>
          </p>
        </a>
        <a href="/report/daybreakdown/">
          <p class="fullwidth">
            <span class="overviewValue">
              <script type="text/javascript">
                $(function() {
                  var activityData = {
                    labels: ['<7am','7','8','9','10','11','12','13','14','15','16','17','18','>19pm'],
                    series: [ [<?php echo $pagedata->activity["0-7"] ?>,<?php echo $pagedata->activity["7-8"] ?>,<?php echo $pagedata->activity["8-9"] ?>,<?php echo $pagedata->activity["9-10"] ?>,<?php echo $pagedata->activity["10-11"] ?>,<?php echo $pagedata->activity["11-12"] ?>,<?php echo $pagedata->activity["12-13"] ?>,<?php echo $pagedata->activity["13-14"] ?>,<?php echo $pagedata->activity["14-15"] ?>,<?php echo $pagedata->activity["15-16"] ?>,<?php echo $pagedata->activity["16-17"] ?>,<?php echo $pagedata->activity["17-18"] ?>,<?php echo $pagedata->activity["18-19"] ?>,<?php echo $pagedata->activity["19-24"] ?>] ]
                  }
                  var activityOptions = {
                    showPoint: true,
                    lineSmooth: true,
                    fullWidth: true,
                    chartPadding: { right: 35, left: 35, bottom: 0 },
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
          <p class="fullwidth" style="padding: 35px 0;">
            <span class="overviewValue">
              <?php echo (@$pagedata->avgfeedback["avgFeedback"]) ? null : "no feedback left" ?>
              <?php for ($i = 0; $i < round(number_format(@$pagedata->avgfeedback["avgFeedback"],2)); $i++) { echo "<img src='/public/images/ICONS-star.svg' alt='star' height='75' width='auto' />"; } ?>
            </span>
            <span class="overviewLabel">Average feedback</span>
          </p>
        </a>
        <a href="/report/categorybreakdown/">
          <p>
            <span class="overviewValue smaller"><?php echo @$pagedata->topcategory["categoryName"] ?></span>
            <span class="overviewLabel">Top category</span>
          </p>
        </a>
        <a href="/report/urgencybreakdown/">
          <p>
            <span class="overviewValue smaller"><?php echo urgency_friendlyname(number_format(@$pagedata->avgurgency["avgUrgency"],0)) ?></span>
            <span class="overviewLabel">Average urgency</span>
          </p>
        </a>
        </div>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
