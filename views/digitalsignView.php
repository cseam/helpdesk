<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">

  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h2><?php echo $pagedata->title ?></h2>
        <p><?php echo $pagedata->details ?></p>
        <table id="changecontrol">
          <thead>
            <tr class="head">
              <th>Locker</th>
              <th>Status</th>
              <th>Owner</th>
              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["lockerid"] ?></td>
                <td><?php if ($value["status"] === "2") {echo "<span class=\"status1\">Ready</span>";} else {echo "<span class=\"status3\">In Progress</span>";} ?></td>
                <td><?php echo $value["name"]?></td>
                <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo substr(strip_tags($value["title"]), 0, 30) ?></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
