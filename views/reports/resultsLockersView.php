<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php ($stats ? include "views/partials/graphs/managerStats.php" : print("no data")) ?>
      </p>
    </div>
    <div id="calllist">
        <?php include "views/partials/listManagerReports.php" ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table id="changecontrol">
          <thead>
            <tr class="head">
              <th>Locker</th>
              <th>Status</th>
              <th>Owner</th>
              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</th>
              <th style="text-align:right;">Return</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["lockerid"] ?></td>
                <td><?php if ($value["status"] === "2") {echo "<span class=\"status1\">Ready</span>";} else {echo "<span class=\"status3\">In Progress</span>";} ?></td>
                <td><?php echo $value["name"]?></td>
                <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo substr(strip_tags($value["title"]), 0, 30) ?></a></td>
                <td>
                  <form action="#" method="post" enctype="multipart/form-data" class="removefromlocker">
                    <input type="hidden" name="callid" value="<?php echo $value["callid"] ?>" />
                    <input type="hidden" name="lockerid" value="<?php echo $value["lockerid"] ?>" />
                    <input type="hidden" name="owner" value="<?php echo $value["name"] ?>" />

                    <?php if ($value["status"] === "2") { ?>
                      <input type="image" id="btn" name="btn" value="View" src="/public/images/ICONS-forward.svg" class="icon" width="24" height="25" alt="return to user" title="return to user" />
                    <?php } ?>
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
<script type="text/javascript">
$('.removefromlocker').submit(function(event){
  if(!confirm("\nPlease Confirm \n\nLocker : "+ this.lockerid.value +" \nOwner : "+ this.owner.value + "\n\nReturn this item?")){
    event.preventDefault();
  }
});
</script>

<?php require_once "views/partials/footer.php"; ?>
