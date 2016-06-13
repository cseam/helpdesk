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
        		<legend>Location Details</legend>
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["id"])) { echo $pagedata->reportResults["id"]; } ?>" />
              <label for="locationName" title="location name">Location name</label>
              <input type="text" id="locationName" name="locationName" value="<?php if (isset($pagedata->reportResults["locationName"])) { echo $pagedata->reportResults["locationName"]; } ?>" REQUIRED/>
              <label for="iconlocation" title="iconlocation">iconlocation (filename in public images)</label>
              <input type="text" id="iconlocation" name="iconlocation" value="<?php if (isset($pagedata->reportResults["iconlocation"])) { echo $pagedata->reportResults["iconlocation"]; } ?>" REQUIRED/>
              <label for="shorthand" title="shorthand">shorthand</label>
              <input type="text" id="shorthand" name="shorthand" value="<?php if (isset($pagedata->reportResults["shorthand"])) { echo $pagedata->reportResults["shorthand"]; } ?>" REQUIRED/>
              <label for="optiongroup" title="optiongroup">optiongroup</label>
              <input type="text" id="optiongroup" name="optiongroup" value="<?php if (isset($pagedata->reportResults["optiongroup"])) { echo $pagedata->reportResults["optiongroup"]; } ?>" REQUIRED/>
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
