<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="calllist">
      <?php include "views/partials/listAdminReports.php" ?>
    </div>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->summary ?></p>
        <p>
          //TODO admin default view
        </p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
