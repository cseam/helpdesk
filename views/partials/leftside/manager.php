<div id="stats">
  <p>
    <?php ($left->sideData["graphdata"] ? include "views/partials/graphs/managerStats.php" : print("no data")) ?>
  </p>
</div>
<div id="calllist">
    <?php include "views/partials/listManagerReports.php" ?>
</div>
