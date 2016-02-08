<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php include "views/partials/graphs/engineerStats.php" ?>
      </p>
    </div>
    <div id="calllist">
        <?php if ($listdata) { include "views/partials/assignedtickets.php"; } else { echo "0 assigned tickets"; }?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <?php if ($ticketDetails) { include "views/partials/viewticket.php"; } else { echo "No open tickets"; }?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
