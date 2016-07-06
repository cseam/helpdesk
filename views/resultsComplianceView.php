<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
          <table id="compliance">
            <thead>
              <tr class="head">
                <th>Title</th>
                <th>Frequency</th>
                <th>Last Completed</th>
                <th>Engineer</th>
                <th>Days ago</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($pagedata->reportResults as $key => $value) { ?>
                <tr>
                  <td><a href="/ticket/view/<?php echo $value["callid"]?>"><?php echo $value["task"]?></a></td>
                  <td><?php echo $value["frequency"]?></td>
                  <td><?php echo $value["compliancedate"]?></td>
                  <td><?php echo $value["engineer"]?></td>
                  <td><?php echo $value["daysago"]?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
