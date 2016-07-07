<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>
  
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <?php include "views/partials/addChangeControl.php"; ?>
        <?php if (!$_POST) { include "views/partials/forms/addChangeControlForm.php"; } ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
