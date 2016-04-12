<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h3><?php echo $pagedata->title; ?></h3>
        <p><?php echo $pagedata->details; ?></p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
