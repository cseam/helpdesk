<?php if (isset($message)) { echo $message; } else {
      if ($ticketDetails["owner"] == $_SESSION['sAMAccountName']) { ?>
    <div id="calldetails">
      <h2>:(</h2>
      <p>
        Engineers cannot leave feedback for themselfs.
      </p>
    </div>
<?php
      } else {
  ?>
<div id="calldetails">
  <h2>Leave Feedback For Ticket #<?php echo $ticketDetails["callid"]; ?></h2>
  <p>
    Please review the ticket details and leave your feedback at the bottom of the page
  </p>
  <table class="noborder">
    <tr>
      <td>
        <?php if (@getimagesize(PROFILE_IMAGES.strtolower($ticketDetails["owner"]).".jpg")) {
          // check profile image exists for user
          echo "<img src=\"".PROFILE_IMAGES.strtolower($ticketDetails["owner"]).".jpg"."\" alt=\"default profile picture\" class=\"profile-picture\" />";
        } else {
          // display default placeholder
          echo "<img src=\"/uploads/profile_images/default.jpg\" alt=\"default profile picture\" class=\"profile-picture\" />";
        }?>
      </td>
      <td>
        <p class="callheader"><span class="nowrap">Created by:</span>       <span class="nowrap"><?php echo $ticketDetails["name"];?></span></p>
        <p class="callheader"><span class="nowrap">Contact number:</span>   <span class="nowrap"><?php echo $ticketDetails["tel"];?></span></p>
        <p class="callheader"><span class="nowrap">Location:</span>         <span class="nowrap"><?php echo $ticketDetails["locationName"];?></span></p>
        <p class="callheader"><span class="nowrap">Room:</span>             <span class="nowrap"><?php echo $ticketDetails["room"];?></span></p>
        <p class="callheader"><span class="nowrap">Category:</span>         <span class="nowrap"><?php echo $ticketDetails["categoryName"];?></span></p>
        <p class="callheader"><span class="nowrap">Assigned to:</span>      <span class="nowrap"><?php echo $ticketDetails["engineerName"];?></span></p>
        <p class="callheader"><span class="nowrap">Opened:</span>           <span class="nowrap"><?php echo date("d/m/Y H:i", strtotime($ticketDetails["opened"]));?></span></p>
        <p class="callheader"><span class="nowrap">Closed:</span>           <span class="nowrap"><?php if ($ticketDetails["closed"]) {echo date("d/m/Y H:i", strtotime($ticketDetails["closed"])); } ?></span></p>
        <p class="callheader"><span class="nowrap">Ticket Age:</span>       <span class="nowrap"><?php echo $ticketDetails["daysold"];?> day(s)</span></p>
        <p class="callheader"><span class="nowrap">Scheduled Ticket:</span> <span class="nowrap"><?php echo $ticketDetails["pm"] == true ? 'Yes' : 'No'; ?></span></p>
        <p class="callheader"><span class="nowrap">Urgency:</span>          <span class="nowrap"><img src="/public/images/ICONS-urgency<?php echo $ticketDetails["urgency"];?>.svg" alt="<?php echo $ticketDetails["urgency"];?>" title="<?php echo $ticketDetails["urgency"];?>" style="height: 14px; width: 100px" /></span></p>
        <p class="callheader"><span class="nowrap">Locker:</span>           <span class="nowrap"><?php echo $ticketDetails["lockerid"];?></span></p>
      </td>
    </tr>
  </table>

  <h3 class="callbody"><?php echo $ticketDetails["title"];?></h3>
    <p class="callbody"><?php echo nl2br($ticketDetails["details"]);?></p>
    <p class="highlight smalltxt">Last Update: <?php echo date("d/m/Y H:i", strtotime($ticketDetails["lastupdate"]));?></p>

    <form action="#" method="post" enctype="multipart/form-data" id="updateForm">
      <input type="hidden" id="id" name="id" value="<?php echo $ticketDetails["callid"]; ?>" />
      <input type="hidden" id="button_value" name="button_value" value="" />
      <fieldset>
        <legend>Leave Feedback</legend>
        <p>Fewer star = lower satisfaction / more stars = greater satisfaction</p>
        <table>
          <thead>
            <tr>
              <th>Satisfaction</th>
              <th>Select</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 1; $i <= 5; $i++) {?>
            <tr>
              <td>
                <label for="satisfaction" style="display: inline-block;">
                  <?php for ($stars = 1; $stars <= $i; $stars++) { echo "<img src=\"/public/images/ICONS-star.svg\" alt=\"star\" width=\"24\" height=\"auto\"/>";} ?>
                </label>
              </td>
              <td>
                <input type="radio" id="satisfaction<?php echo $i ?>" name="satisfaction" value="<?php echo $i ?>" required>
              </td>
            </tr>
            <? } ?>
          </tbody>
        </table>
        <p>Please leave any additional comments</p>
        <p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40" required></textarea></p>
        <div class="buttons">
          <button name="feedback" value="feedback" type="submit" onclick="this.form.button_value.value = this.value;">Leave Feedback</button>
        </div>
      </fieldset>
    </form>
    <script type="text/javascript">
      $(function() {
        // Wait for DOM ready state
        // Client side form validation
        $("#updateForm").validate();
      });
    </script>
</div>
<?php } } ?>
