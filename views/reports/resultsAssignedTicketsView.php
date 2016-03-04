<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php include "views/partials/graphs/reportStats.php" ?>
      </p>
    </div>
    <div id="calllist">
        <?php include "views/partials/listReportReports.php" ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table id="tablesorter" class="tablesorter">
          <thead>
            <tr>
              <th>Engineer Name</th>
              <th>Helpdesk</th>
              <th>Open Tickets Assigned</th>
              <th>Total Ever</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td><?php echo $value["engineerName"] ?></td>
              <td><?php echo $value["helpdesk_name"] ?></td>
              <td><?php echo $value["OpenOnes"] ?></td>
              <td><?php echo $value["HowManyAssigned"] ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

        <script>
        // activate table sorting jquery library
        $(document).ready(function() {
                $("#tablesorter").tablesorter();
        });
        </script>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
