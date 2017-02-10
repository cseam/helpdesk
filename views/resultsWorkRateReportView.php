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
              <th>Engineer Name</th>
              <th>Helpdesk</th>
              <th>30 Days</th>
              <th>7 Days</th>
              <th>24 Hours</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($pagedata->reportResults)) {
            foreach ($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td><?php echo $value["engineerName"] ?></td>
              <td><?php echo $value["helpdesk_name"] ?></td>
              <td><?php echo $value["Last30"] ?></td>
              <td><?php echo $value["Last7"] ?></td>
              <td><?php echo $value["Last1"] ?></td>
            </tr>
            <?php }
            } ?>
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
