<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <p><form action="#" method="post" id="addForm">
            <input type="hidden" id="button_value" name="button_value" value="" />
            <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Add Out Of Hours</button>
        </form></p>
        <table id="changecontrol">
              <thead>
                <tr>
                  <th>Date/Time/Problem</th>
                  <th>Reported by</th>
                </tr>
              </thead>
            <?php
            if (isset($pagedata->reportResults)) {
            foreach ($pagedata->reportResults as $key => $value) { ?>
              <tbody>
              <tr>
                <td><?php echo $value["dateofcall"] ?> @ <?php echo $value["timeofcall"] ?></td>
                <td><?php echo $value["calloutby"] ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo nl2br($value["problem"]) ?></td>
              </tr>
              </tbody>
            <?php }
            } ?>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
