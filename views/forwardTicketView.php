<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <?php include "views/partials/viewticketwelcome.php"; ?>
    </div>
    <div id="calllist">
        <?php include "views/partials/yourtickets.php"; ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <?php include "views/forms/forwardForm.php"; ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
