<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage"></div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->message ?></p>
      </div>
    </div>
  </div>

<?php require_once "views/partials/footer.php"; ?>
