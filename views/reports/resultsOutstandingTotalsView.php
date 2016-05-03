<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table>
          <thead>
            <tr>
              <th>Status</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Escalated</td>
              <td><?php echo $pagedata->escalated["countTotal"] ?></td>
            </tr>
            <tr>
              <td>Unassigned</td>
              <td><?php echo $pagedata->unassigned ?></td>
            </tr>
            <tr>
              <td>On Hold</td>
              <td><?php echo $pagedata->onhold["countTotal"] ?></td>
            </tr>
            <tr>
              <td>Sent Away</td>
              <td><?php echo $pagedata->sentaway["countTotal"] ?></td>
            </tr>
            <tr>
              <td>Over 7 Days</td>
              <td><?php echo $pagedata->over7days ?></td>
            </tr>
            <tr>
              <td>Open</td>
              <td><?php echo $pagedata->open["countTotal"] ?></td>
            </tr>
          </tbody>
        </table>
        <p>
          Breakdown totals by engineer
        </p>
        <table>
          <thead>
            <tr>
              <th>Engineer</th>
              <th>Open</th>
              <th>On Hold</th>
              <th>Escalated</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(isset($pagedata->reportResults)) {
            foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["engineerName"] ?></td>
                <td><?php echo $value["open"] ?></td>
                <td><?php echo $value["onhold"] ?></td>
                <td><?php echo $value["escalated"] ?></td>
              </tr>
            <?php
              }
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
