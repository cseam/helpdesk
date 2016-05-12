<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/user.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <form action="#" method="post" id="modifyForm">
          <fieldset>
            <legend>Profile Default Details</legend>
              <input type="hidden" id="id" name="id" value="<?php if (isset($pagedata->reportResults["id"])) { echo $pagedata->reportResults["id"]; } ?>" />
              <input type="hidden" id="button_value" name="button_value" value="" />
              <label for="contactName" title="Contact Name">Your/Contact Name</label>
              <input type="text" id="contactName" name="contactName" value="<?php if (isset($pagedata->reportResults["contactName"])) { echo $pagedata->reportResults["contactName"]; } ?>" REQUIRED/>

              <label for="contactEmail" title="Contact Email">Contact Email</label>
              <input type="text" id="contactEmail" name="contactEmail" value="<?php if (isset($pagedata->reportResults["contactEmail"])) { echo $pagedata->reportResults["contactEmail"]; } ?>" REQUIRED/>

              <label for="contactTel" title="Contact Tel">Telephone / Mobile Number</label>
              <input type="text" id="contactTel" name="contactTel" value="<?php if (isset($pagedata->reportResults["contactTel"])) { echo $pagedata->reportResults["contactTel"]; } ?>" REQUIRED/>

              <label for="location" title="location of issue">Building</label>
              <select id="location" name="location" REQUIRED>
                <option value="" SELECTED>Please Select</option>
                <?php foreach ($pagedata->location as $key => $value) { ?>
                <option value="<?php echo $value["id"] ?>" <?php if($value["id"] == $pagedata->reportResults["location"]) { echo "SELECTED"; } ?>><?php echo $value["locationName"] ?></option>
              <?php  } ?>
              </select>
          </fieldset>
          <!--
          <fieldset>
            <legend>Profile Picture</legend>
              <p>//TODO ability to update profile picture shown in tickets</p>
          </fieldset>
          <fieldset>
            <legend>Notifications</legend>
              <p>//TODO ability to set scope and notifications of issues in users area</p>
          -->
              <p class="buttons">
                <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Update</button>
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
