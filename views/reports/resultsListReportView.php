<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php include "views/partials/graphs/managerStats.php" ?>
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

        <table id="yourcalls">
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td class="hdtitle">#<?php echo $value["callid"] ?></td>
              <td class="hdtitle" colspan="4"><?php echo $value["title"] ?></td>
            </tr>
            <tr>
              <td><span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span></td>
              <td><?php echo date("d/m/y", strtotime($value["opened"])) ?></td>
              <td><img src="/public/images/<?php echo $value["iconlocation"] ?>" width="24" height="25" title="<?php echo $value["locationName"] ?>"/></td>
              <td><?php echo $value["engineerName"] ?></td>
              <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
