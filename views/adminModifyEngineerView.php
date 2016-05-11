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
        		<legend>Helpdesk Details</legend>
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["idengineers"])) { echo $pagedata->reportResults["idengineers"]; } ?>" />

              <label for="engineerName" title="engineerName">Engineer name</label>
              <input type="text" id="engineerName" name="engineerName" value="<?php if (isset($pagedata->reportResults["engineerName"])) { echo $pagedata->reportResults["engineerName"]; } ?>" REQUIRED/>

              <label for="engineerEmail" title="engineerEmail">Engineer Email</label>
              <input type="text" id="engineerEmail" name="engineerEmail" value="<?php if (isset($pagedata->reportResults["engineerEmail"])) { echo $pagedata->reportResults["engineerEmail"]; } ?>" REQUIRED/>

              <label for="availableDays" title="availableDays">available Days (comma delimited day numbers)</label>
              <input type="text" id="availableDays" name="availableDays" value="<?php if (isset($pagedata->reportResults["availableDays"])) { echo $pagedata->reportResults["availableDays"]; } ?>" REQUIRED/>

              <label for="sAMAccountName" title="sAMAccountName">sAMAccountName</label>
              <input type="text" id="sAMAccountName" name="sAMAccountName" value="<?php if (isset($pagedata->reportResults["sAMAccountName"])) { echo $pagedata->reportResults["sAMAccountName"]; } ?>" REQUIRED/>

              <label for="engineerLevel" title="engineerLevel">Engineer Level</label>
              <input type="text" id="engineerLevel" name="engineerLevel" value="<?php if (isset($pagedata->reportResults["engineerLevel"])) { echo $pagedata->reportResults["engineerLevel"]; } ?>" REQUIRED/>

              <label for="helpdesk" title="helpdesk">Helpdesk</label>
              <select id="helpdesk" name="helpdesk" REQUIRED>
                <option value="" SELECTED>Please Select</option>
                <?php foreach ($pagedata->helpdesks as $key => $value) { ?>
                <option value="<?php echo $value["id"] ?>" <?php if($value["id"] == $pagedata->reportResults["helpdesk"]) { echo "SELECTED"; } ?>><?php echo $value["helpdesk_name"] ?></option>
              <?php  } ?>
              </select>

              <label for="superuser" title="superuser">superuser (BOOL)</label>
              <input type="text" id="superuser" name="superuser" value="<?php if (isset($pagedata->reportResults["superuser"])) { echo $pagedata->reportResults["superuser"]; } ?>" />

              <label for="disabled" title="disabled">disabled (BOOL)</label>
              <input type="text" id="disabled" name="disabled" value="<?php if (isset($pagedata->reportResults["disabled"])) { echo $pagedata->reportResults["disabled"]; } ?>" />

              <label for="localLoginHash" title="localLoginHash">localLoginHash (ADV)</label>
              <input type="text" id="localLoginHash" name="localLoginHash" value="<?php if (isset($pagedata->reportResults["localLoginHash"])) { echo $pagedata->reportResults["localLoginHash"]; } ?>" />

              <p class="buttons">
              <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">
                <?php isset($pagedata->reportResults["idengineers"]) ? print("Update") : print("Add");?>
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
