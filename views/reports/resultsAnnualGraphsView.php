<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>


<script type="text/javascript">

  $(function() {
new Chartist.Line('.annualgraph', {
  labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
  series: [
    <?php
    foreach($pagedata->graphstats as $key => $value) {
      echo "[";
        foreach($value as $sqlname => $sqlvalue) {
          echo $sqlvalue["result"] . ",";
        }
      echo "],";
    } ?>


  ]
}, {
  fullWidth: true,
  chartPadding: {
    right: 40
  }
});

});
</script>
<div class="annualgraph"></div>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
