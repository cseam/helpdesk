<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php
    // temp removed as not happy with it include "views/partials/ticketTimeline.php";
    include "views/partials/leftside/".$left->sideData["partial"];
    ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <?php if (isset($pagedata->sla)) { ?>
          <h3>Service Level Agreement</h3>
          <p>Your ticket has been assigned the following service level agreement:
          <p><?php echo $pagedata->sla["agreement"] ?></p>
          <p>Expected date your ticket will be closed is on or before <?php echo date("d-m-Y", strtotime(date("d-m-Y", strtotime(date("d-m-Y"))).$pagedata->sla["close_eta_days"]." days")) ?></p>
        <?php } ?>
        <p><?php if (isset($pagedata->outofhourscontact)) { echo $pagedata->outofhourscontact; } ?></p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
