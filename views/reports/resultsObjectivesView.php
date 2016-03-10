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
          //TODO crud performance objectives
        </p>
        <table id="changecontrol">
              <thead>
                <tr>
                  <th>Objective</th>
                  <th>Engineer</th>
                  <th>Due</th>
                  <th>Progress</th>
                </tr>
              </thead>
              <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo substr(strip_tags($value["title"]), 0, 50) ?></td>
                <td><?php echo $value["engineerName"] ?></td>
                <td><?php echo date("M Y", strtotime($value["datedue"]))  ?></td>
                <td><?php echo $value["progress"] ?>%</td>
              </tr>
            <?php } ?>
            </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
