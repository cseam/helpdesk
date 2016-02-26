<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php include "views/partials/graphs/managerStats.php" ?>
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
          //TODO Form Post
        </p>
        <?php include "views/forms/searchForm.php" ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
