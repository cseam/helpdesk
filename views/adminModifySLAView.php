<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="calllist">
      <?php include "views/partials/listAdminReports.php" ?>
    </div>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <form action="#" method="post" id="modifyForm">
          <fieldset>
        		<legend>SLA Details</legend>
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["id"])) { echo $pagedata->reportResults["id"]; } ?>" />

              <label for="agreement" title="agreement">agreement</label>
              <input type="text" id="agreement" name="agreement" value="<?php if (isset($pagedata->reportResults["agreement"])) { echo $pagedata->reportResults["agreement"]; } ?>" REQUIRED/>

              <label for="close_eta_days" title="close_eta_days">close eta days</label>
              <input type="text" id="close_eta_days" name="close_eta_days" value="<?php if (isset($pagedata->reportResults["close_eta_days"])) { echo $pagedata->reportResults["close_eta_days"]; } ?>" REQUIRED/>

              <label for="urgency" title="urgency">Urgency</label>
              <select id="urgency" name="urgency" REQUIRED>
                <option value="" SELECTED>Please Select</option>
                <option value="1" <?php if ($pagedata->reportResults["urgency"] == 1) { echo "SELECTED"; } ?>>1</option>
                <option value="2" <?php if ($pagedata->reportResults["urgency"] == 2) { echo "SELECTED"; } ?>>2</option>
                <option value="3" <?php if ($pagedata->reportResults["urgency"] == 3) { echo "SELECTED"; } ?>>3</option>
                <option value="4" <?php if ($pagedata->reportResults["urgency"] == 4) { echo "SELECTED"; } ?>>4</option>
                <option value="5" <?php if ($pagedata->reportResults["urgency"] == 5) { echo "SELECTED"; } ?>>5</option>
                <option value="6" <?php if ($pagedata->reportResults["urgency"] == 6) { echo "SELECTED"; } ?>>6</option>
                <option value="7" <?php if ($pagedata->reportResults["urgency"] == 7) { echo "SELECTED"; } ?>>7</option>
                <option value="8" <?php if ($pagedata->reportResults["urgency"] == 8) { echo "SELECTED"; } ?>>8</option>
                <option value="9" <?php if ($pagedata->reportResults["urgency"] == 9) { echo "SELECTED"; } ?>>9</option>
                <option value="10" <?php if ($pagedata->reportResults["urgency"] == 10) { echo "SELECTED"; } ?>>10</option>
              </select>

              <label for="helpdesk" title="helpdesk">Helpdesk</label>
              <select id="helpdesk" name="helpdesk" REQUIRED>
                <option value="" SELECTED>Please Select</option>
                <?php foreach ($pagedata->helpdesks as $key => $value) { ?>
                <option value="<?php echo $value["id"] ?>" <?php if ($value["id"] == $pagedata->reportResults["helpdesk"]) { echo "SELECTED"; } ?>><?php echo $value["helpdesk_name"] ?></option>
              <?php  } ?>
              </select>

              <p class="buttons">
              <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">
                <?php isset($pagedata->reportResults["id"]) ? print("Update") : print("Add"); ?>
              </button>
              </p>
          </fieldset>
        </form>
        <script type="text/javascript">
        	$(function() {
        		// Wait for DOM ready state
        		// Client side form validation
        		$("#modifyForm").validate({});
        	});
        </script>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
