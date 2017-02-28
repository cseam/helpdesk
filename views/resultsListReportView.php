<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table id="yourcalls">
          <tbody>
            <?php if (isset($pagedata->reportResults)) { foreach ($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td class="hdtitle listheader" colspan="6"><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo $value["title"] ?></a></td>
            </tr>
            <?php if (isset($value["requiredfor"])) { ?>
              <tr><td class="hdtitle" colspan="6"><?php echo $value["requiredfor"] ?></td></tr>
            <?php } ?>
            <tr>
              <td>
                <?php if ($value["userupdate"] === '0') { ?>
                  <span class="status7" title="Ticket updated by user">User Updated</span>
                <?php } else { ?>
                  <span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span>
                <?php } ?>
              </td>
              <td>#<?php echo $value["callid"] ?></td>
              <td><?php echo date("d/m/Y", strtotime($value["opened"])) ?> - <?php echo $value["daysold"] ?> days</td>
              <td><img src="/public/images/<?php echo $value["iconlocation"] ?>" width="19" height="20" alt="<?php echo $value["locationName"] ?>" title="<?php echo $value["locationName"] ?>"/></td>
              <td><?php echo $value["engineerName"] ?></td>
              <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
