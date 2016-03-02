<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php include "views/partials/graphs/engineerStats.php" ?>
      </p>
    </div>
    <div id="calllist">
        <?php ($listdata ? include "views/partials/assignedtickets.php" : print("0 assigned tickets")) ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <?php ($ticketDetails ? include "views/partials/viewticket.php" : print("No open tickets")) ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
