<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <?php include "views/partials/userwelcome.php"; ?>
    </div>
    <div id="calllist">
      <?php include "views/partials/yourtickets.php"; ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->summary ?></p>
        <p>
          //TODO add new ticket
        </p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
