<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    //TODO Left side
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <?php include "views/partials/modifyScheduledtask.php"; ?>
        <?php if (!$_POST) { include "views/forms/modifyScheduledtaskForm.php"; } ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
