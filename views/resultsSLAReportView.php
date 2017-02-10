<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <h3>Service Level Overview</h3>
        <table class="tablesorter">
          <thead>
            <tr>
              <th>Level</th>
              <th style="text-align: left;">Agreement</th>
              <th>Total</th>
              <th>First Response Success</th>
              <th>Close Time Success</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($pagedata->SLAtotals)) {
              $pietotal = $firsttotal = $closetotal = 0;
              foreach ($pagedata->SLAtotals as &$value) {
                $pietotal += $value["Total"];
                $firsttotal += $value["FirstResponseSuccess"];
                $closetotal += $value["ResponseTimeSuccess"];
                ?>
            <tr>
              <td><?php echo $value["SLA"] ?></td>
              <td style="text-align: left;"><?php echo $value["Agreement"] ?></td>
              <td><?php echo $value["Total"] ?></td>
              <td><?php echo number_format(($value["Total"] !== 0 ? ($value["FirstResponseSuccess"] / $value["Total"]) : 0) * 100, 2)."%"; ?></td>
              <td><?php echo number_format(($value["Total"] !== 0 ? ($value["ResponseTimeSuccess"] / $value["Total"]) : 0) * 100, 2)."%"; ?></td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>
        <br />
        <h3>Performance Totals</h3>
        <script type="text/javascript">
          $(function() {
            // WAIT FOR DOM
            var pieData = { series: [<?php echo $firsttotal ?>,<?php echo $pietotal - $firsttotal ?>] };
            var pieOptions = { donut: false, showLabel: false, chartPadding: {top: 20} };
            new Chartist.Pie('#frperformance', pieData, pieOptions);
            var pieData = { series: [<?php echo $closetotal ?>,<?php echo $pietotal - $closetotal ?>] };
            var pieOptions = { donut: false, showLabel: false, chartPadding: {top: 20} };
            new Chartist.Pie('#clperformance', pieData, pieOptions);
          });
        </script>
        <div id="frperformance" style="width: 50%;float: left;">First Response Success Rate (total)</div>
        <div id="clperformance" style="width: 50%;float: left;">Close Time Success Rate (total)</div>
        <br style="clear:both;" />
        <br />
        <h3>Failed Tickets</h3>
        <table id="tablesorter" class="tablesorter" >
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Helpdesk</th>
              <th>Engineer</th>
              <th>Overdue By</th>
              <th>View</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($pagedata->reportResults)) {
            foreach ($pagedata->reportResults as $key => $value) {
              if (($value["total_days_to_close"] - $value["close_eta_days"]) > 0) {
              ?>
            <tr>
              <td>#<?php echo $value["callid"] ?></td>
              <td class="left"><?php echo substr(strip_tags($value["title"]), 0, 50) ?></td>
              <td><?php echo $value["helpdesk_name"] ?></td>
              <td><?php echo $value["engineerName"] ?></td>
              <td><?php echo $value["total_days_to_close"] - $value["close_eta_days"] ?> days</td>
              <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
            </tr>
            <?php
              }
            }
            } ?>
          </tbody>
        </table>
        <script>
        // activate table sorting jquery library
        $(document).ready(function() { $("#tablesorter").tablesorter(); });
        </script>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
