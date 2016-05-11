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
        		<legend>Additional Details</legend>
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["id"])) { echo $pagedata->reportResults["id"]; } ?>" />
              <label for="label" title="label name">Label</label>
              <input type="text" id="label" name="label" value="<?php if (isset($pagedata->reportResults["label"])) { echo $pagedata->reportResults["label"]; } ?>" REQUIRED/>

              <label for="typeid" title="typeid">Catagory for</label>
              <select id="typeid" name="typeid" REQUIRED>
        				<option value="" SELECTED>Please Select</option>
        				<?php foreach ($pagedata->catagories as $key => $value) { ?>
                <option value="<?php echo $value["id"] ?>" <?php if($value["id"] == $pagedata->reportResults["typeid"]) { echo "SELECTED"; } ?>><?php echo $value["categoryName"] ?></option>
              <?php  } ?>
        			</select>

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
