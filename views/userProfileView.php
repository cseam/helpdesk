<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/user.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <form action="#" method="post" id="modifyForm" enctype="multipart/form-data">
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
          <fieldset>
            <legend>Profile Picture</legend>
            <?php if (@getimagesize(PROFILE_IMAGES.strtolower($_SESSION['sAMAccountName']).".jpg")) {
              // check profile image exists for user
              echo "<img src=\"".PROFILE_IMAGES.strtolower($_SESSION['sAMAccountName']).".jpg"."\" alt=\"default profile picture\" class=\"profile-picture\" style=\"margin:1rem;\" />";
            } else {
              // display default placeholder
              echo "<img src=\"/uploads/profile_images/default.jpg\" alt=\"default profile picture\" class=\"profile-picture\" style=\"margin:1rem;\" />";
            }?>
              <p>This is your profile picture, it is attached to any ticket you create to help engineers identify users, pictures are periodicaly updated from College's repository, however if you would like to update your picture with one of your choosing please upload a picture here.</p>
              <label for="attachment" title="add attachments if required">Change Profile Picture</label>
        			<input type="file" name="attachment" accept="image/jpeg" class="clearbreak">
          </fieldset>
          <fieldset>
            <legend>Notifications</legend>
              <p>Notify me of any tickets added in this location via email, you will still get notifications for tickets you have created regardless of this setting.</p>
              <p><span class="note">(WARNING: this can generate a lot of email, do not set unless you want these emails)</span></p>
              <select id="notify" name="notify">
                <option value="" SELECTED>No Area Notifications</option>
                <?php foreach ($pagedata->location as $key => $value) { ?>
                <option value="<?php echo $value["id"] ?>" <?php if($value["id"] == $pagedata->reportResults["notify"]) { echo "SELECTED"; } ?>><?php echo $value["locationName"] ?></option>
              <?php  } ?>
              </select>
              <p>This can be useful for house staff working shift patterns to maintain visability of tickets logged by other house members</p>


              <p class="buttons">
                <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Update Profile</button>
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
