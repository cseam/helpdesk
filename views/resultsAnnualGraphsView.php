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
    foreach ($pagedata->graphstats as $key => $value) {
      echo "[";
        foreach ($value as $resultskey => $resultsvalue) {
          echo $resultsvalue.",";
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
<div class="annualgraph" style="height: 50vh;"></div>
<?php
  $counter = 0;
  foreach ($pagedata->graphstats as $key => $value) {
    $counter++;
    ?>
  <span style="font-size: 0.7rem;color: white;padding: 0.1rem 0.5rem;" class="ct-series-<?php echo $counter ?>"><?php echo $key; ?></span>
<?php  } ?>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
