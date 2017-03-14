<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <h3>User left following feedback for ticket <?php echo $pagedata->feedback[0]["callid"] ?></h3>
        <p><?php for ($stars = 1; $stars <= $pagedata->feedback[0]["satisfaction"]; $stars++) { echo "<img src=\"/public/images/ICONS-star.svg\" alt=\"star\" width=\"24\" height=\"auto\"/>"; } ?></p>
        <p>Message:<br/><?php echo $pagedata->feedback[0]["details"] ?></p>
        <p>Left By:<br/><?php echo $pagedata->feedback[0]["email"] ?></p>
        <h3>Manager Feedback for this User feedback</h3>
        <p>This is only visible to other Managers. Engineers/Users do not see this note its a Managerial note about actions taken or reasons behind feedback.</p>
        <p>
          <?php if (isset($pagedata->managerNotes)) {
                  foreach ($pagedata->managerNotes as &$note) { ?>
                    <div class="update"><?php echo nl2br($note["note"]); ?></div>
                    <?php
                  }
                }
          ?>
        </p>
        <?php include "views/partials/forms/addNoteForm.php"; ?>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
