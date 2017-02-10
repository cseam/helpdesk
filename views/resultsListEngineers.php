<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table id="yourcalls">
          <tbody>
            <?php foreach ($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td><a href="/report/recentwork/<?php echo $value["idengineers"] ?>" alt="view report"><?php echo $value["engineerName"] ?></a></td>
              <td><a href="/report/recentwork/<?php echo $value["idengineers"] ?>" alt="view report"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view report" /></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
