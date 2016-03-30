<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">

    </div>
    <div id="calllist">

    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <p><?php if($pagedata->sla) { print_r($pagedata->sla); } ?></p>

        //TODO sort this crap tomorrow
        <h3>Service Level Agreement</h3>
        <p>Your ticket has been assigned the following service level agreement:
        <p><?php echo($SLA);?></p>
        <p>Expected date your ticket will be closed is on or before <?php echo($SLAETA);?></p>
        // end todo
        <p><?php if($pagedata->outofhourscontact) { echo $pagedata->outofhourscontact; } ?></p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
