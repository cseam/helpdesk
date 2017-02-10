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
        		<legend>Quick Response Details</legend>
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["id"])) { echo $pagedata->reportResults["id"]; } ?>" />
              <label for="quick_response" title="quick_response">Quick Response</label>
              <input type="text" id="quick_response" name="quick_response" value="<?php if (isset($pagedata->reportResults["quick_response"])) { echo $pagedata->reportResults["quick_response"]; } ?>" REQUIRED/>
              <label for="helpdesk_id" title="helpdesk_id">helpdesk</label>

              <select id="helpdesk_id" name="helpdesk_id" REQUIRED>
        				<option value="" SELECTED>Please Select</option>
        				<?php foreach ($pagedata->helpdesks as $key => $value) { ?>
                <option value="<?php echo $value["id"] ?>" <?php if ($value["id"] == $pagedata->reportResults["helpdesk_id"]) { echo "SELECTED"; } ?>><?php echo $value["helpdesk_name"] ?></option>
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
