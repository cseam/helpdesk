<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>

        <h3 class="default-padding"><?php echo sizeof($pagedata->escalatedResults) ?> Escalated Tickets</h3>
        <?php if (!$pagedata->escalatedResults) { echo "<p>0 Escalated tickets.</p>"; } ?>
        <table id="escalatedtickets">
          <tbody>
            <?php if (isset($pagedata->escalatedResults)) { foreach($pagedata->escalatedResults as $key => $value) { ?>
              <tr>
                <td class="hdtitle listheader" colspan="6"><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo $value["title"] ?></a></td>
              </tr>
              <tr>
                <td><span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span></td>
                <td>#<?php echo $value["callid"] ?></td>
                <td><?php echo date("d/m/Y", strtotime($value["opened"])) ?> - <?php echo $value["daysold"] ?> days</td>
                <td><img src="/public/images/<?php echo $value["iconlocation"] ?>" width="19" height="20" alt="<?php echo $value["locationName"] ?>" title="<?php echo $value["locationName"] ?>"/></td>
                <td><?php echo $value["engineerName"] ?></td>
                <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>

        <h3 class="default-padding"><?php echo sizeof($pagedata->unassignedResults) ?> New/Unassigned Tickets</h3>
        <?php if (!$pagedata->unassignedResults) { echo "<p>0 Unassigned tickets.</p>"; } ?>
        <table id="unassignedtickets">
          <tbody>
            <?php if (isset($pagedata->unassignedResults)) { foreach($pagedata->unassignedResults as $key => $value) { ?>
              <tr>
                <td class="hdtitle listheader" colspan="6"><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo $value["title"] ?></a></td>
              </tr>
              <tr>
                <td><span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span></td>
                <td>#<?php echo $value["callid"] ?></td>
                <td><?php echo date("d/m/Y", strtotime($value["opened"])) ?> - <?php echo $value["daysold"] ?> days</td>
                <td><img src="/public/images/<?php echo $value["iconlocation"] ?>" width="19" height="20" alt="<?php echo $value["locationName"] ?>" title="<?php echo $value["locationName"] ?>"/></td>
                <td><?php echo $value["engineerName"] ?></td>
                <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>

        <h3 class="default-padding"><?php echo sizeof($pagedata->stagnateResults) ?> Stagnant Tickets</h3>
        <?php if (!$pagedata->stagnateResults) { echo "<p>0 Stagnant tickets.</p>"; } else { echo "<p>Stagnant tickets are tickets not updated in 72 hours, these tickets should be updated so user knows what is happening or put on hold/sent away.</p>"; } ?>

        <table id="stagnatetickets">
          <tbody>
            <?php if (isset($pagedata->stagnateResults)) { foreach($pagedata->stagnateResults as $key => $value) { ?>
              <tr>
                <td class="hdtitle listheader" colspan="6"><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo $value["title"] ?></a></td>
              </tr>
              <tr>
                <td><span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span></td>
                <td>#<?php echo $value["callid"] ?></td>
                <td><?php echo date("d/m/Y", strtotime($value["opened"])) ?> - <?php echo $value["daysold"] ?> days</td>
                <td><img src="/public/images/<?php echo $value["iconlocation"] ?>" width="19" height="20" alt="<?php echo $value["locationName"] ?>" title="<?php echo $value["locationName"] ?>"/></td>
                <td><?php echo $value["engineerName"] ?></td>
                <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>

        <h3 class="default-padding">Poor Feedback</h3>
        <?php if (!$pagedata->poorfeedbackResults) { echo "<p>0 Poor Feedback tickets in last 30 days.</p>"; } else { echo "<p>Poor feedback left recently for these tickets, you may wish to speak with the ticket owner to address this.</p>"; } ?>
        <table id="poorfeedback">
          <tbody>
            <?php if (isset($pagedata->poorfeedbackResults)) { foreach($pagedata->poorfeedbackResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["engineerName"] ?></td>
                <td><?php echo $value["owner"] ?></td>
                <td><?php echo $value["details"] ?></td>
                <td><?php for ($i = 0; $i < round($value["satisfaction"]); $i++) { echo "<img src='/public/images/ICONS-star.svg' alt='star' height='24' width='auto' />"; } ?></td>
                <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
