<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php ($stats ? include "views/partials/graphs/managerStats.php" : print("no data")) ?>
      </p>
    </div>
    <div id="calllist">
        <?php include "views/partials/listManagerReports.php" ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <p>
          //TODO crud out of hours
        </p>
        <table id="changecontrol">
              <thead>
                <tr>
                  <th>Date/Time/Problem</th>
                  <th>Reported by</th>
                </tr>
              </thead>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tbody>
              <tr>
                <td><?php echo $value["dateofcall"] ?> @ <?php echo $value["timeofcall"] ?></td>
                <td><?php echo $value["calloutby"] ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo nl2br($value["problem"]) ?></td>
              </tr>
              </tbody>
            <?php } ?>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
