<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $error->title ?></h1>
        <p><?php echo $error->message ?></p>
      </div>
    </div>
  </div>

<?php require_once "views/partials/footer.php"; ?>
