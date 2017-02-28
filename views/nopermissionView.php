<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
      <?php include "views/partials/leftside/".$left->sideData["partial"]; ?>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h2>Access Denied.</h2>
        <p>You are not the owner of this ticket and do not have permission to view the ticket details.</p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
