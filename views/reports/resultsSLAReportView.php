<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table id="tablesorter" class="tablesorter">
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
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td>#<?php echo $value["callid"] ?></td>
              <td class="left"><?php echo substr(strip_tags($value["title"]), 0, 50) ?></td>
              <td><?php echo $value["helpdesk_name"] ?></td>
              <td><?php echo $value["engineerName"] ?></td>
              <td><?php echo $value["total_days_to_close"] - $value["close_eta_days"] ?> days</td>
              <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
            </tr>
            <?php } ?>
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
