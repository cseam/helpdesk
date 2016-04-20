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
        <?php include "views/partials/viewticket.php"; ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
