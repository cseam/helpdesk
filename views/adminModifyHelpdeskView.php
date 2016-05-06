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
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["id"])) { echo $pagedata->reportResults["id"]; } ?>" />

              <label for="helpdesk_name" title="helpdesk_name">Helpdesk name</label>
              <input type="text" id="helpdesk_name" name="helpdesk_name" value="<?php if (isset($pagedata->reportResults["helpdesk_name"])) { echo $pagedata->reportResults["helpdesk_name"]; } ?>" REQUIRED/>

              <label for="description" title="description">description</label>
              <input type="text" id="description" name="description" value="<?php if (isset($pagedata->reportResults["description"])) { echo $pagedata->reportResults["description"]; } ?>" REQUIRED/>

              <label for="deactivate" title="deactivate">active/deactive (BOOL)</label>
              <input type="text" id="deactivate" name="deactivate" value="<?php if (isset($pagedata->reportResults["deactivate"])) { echo $pagedata->reportResults["deactivate"]; } ?>" REQUIRED/>

              <label for="auto_assign" title="auto_assign">auto assign tickets (BOOL)</label>
              <input type="text" id="auto_assign" name="auto_assign" value="<?php if (isset($pagedata->reportResults["auto_assign"])) { echo $pagedata->reportResults["auto_assign"]; } ?>" REQUIRED/>

              <label for="email_on_newticket" title="email_on_newticket">email on newticket (BOOL)</label>
              <input type="text" id="email_on_newticket" name="email_on_newticket" value="<?php if (isset($pagedata->reportResults["email_on_newticket"])) { echo $pagedata->reportResults["email_on_newticket"]; } ?>" REQUIRED/>

              <p class="buttons">
              <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">
                <?php isset($pagedata->reportResults["id"]) ? print("Update") : print("Add");?>
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
