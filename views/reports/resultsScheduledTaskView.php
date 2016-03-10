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
          //TODO crud scheduled tasks
        </p>
        <table id="changecontrol">
          <thead>
            <tr class="head">
              <th>#</th>
              <th>Title</th>
              <th>Scheduled</th>
              <th>Update</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["callid"] ?></td>
                <td><?php echo $value["title"]?></td>
                <td><?php echo $value["frequencytype"]?></td>
                <td>//TODO update</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
