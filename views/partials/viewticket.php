<div id="calldetails">
  <!-- //need to correct this update process -->
  <form action="/ticket/update" method="post" enctype="multipart/form-data" id="updateForm">
    <input type="hidden" id="id" name="id" value="<?php echo $ticketDetails["callid"]; ?>" />
    <input type="hidden" id="button_value" name="button_value" value="" />
    <input type="hidden" id="details" name="details" value="<?php echo $ticketDetails["details"];?>" />
    <h2>Ticket details #<?php echo $ticketDetails["callid"]; ?></h2>
    <p class="callheader">#<?php echo $ticketDetails["callid"];?></p>
    <p class="callheader">Category: <?php echo $ticketDetails["categoryName"];?></p>
    <p class="callheader">Created by: <?php echo $ticketDetails["name"];?></p>
    <p class="callheader">Contact number: <?php echo $ticketDetails["tel"];?></p>
    <p class="callheader">Location: <?php echo $ticketDetails["locationName"];?></p>
    <p class="callheader">Room: <?php echo $ticketDetails["room"];?></p>
    <p class="callheader">Assigned to: <?php echo $ticketDetails["assigned"];?></p>
    <p class="callheader">Opened: <?php echo date("d/m/Y H:i:s", strtotime($ticketDetails["opened"]));?></p>
    <p class="callheader">Closed: <?php echo date("d/m/Y H:i:s", strtotime($ticketDetails["closed"]));?></p>
    <p class="callheader">Last Update: <?php echo date("d/m/Y H:i:s", strtotime($ticketDetails["lastupdate"]));?></p>
    <p class="callheader">Locker: <?php echo $ticketDetails["lockerid"];?></p>
    <h3 class="callbody"><?php echo $ticketDetails["title"];?></h3>
    <p class="callbody">
      <ul>
        <?php foreach ($additionalDetails as $key => $value) { echo "<li>" . $value["label"] .": ". $value["value"] . "</li>"; } ?>
      </ul>
    </p>
    <p class="callbody">

      <?php if (@getimagesize(PROFILE_IMAGES . strtolower($ticketDetails["owner"]) . ".jpg")) {
        // check profile image exists for user
        echo "<img src=\" " . PROFILE_IMAGES . strtolower($ticketDetails["owner"]) . ".jpg" . "\" alt=\"default profile picture\" class=\"profile-picture\" />";
      } else {
        // display default placeholder
        echo "<img src=\"/uploads/profile_images/default.jpg\" alt=\"default profile picture\" class=\"profile-picture\" />";
      }?>
      <?php echo nl2br($ticketDetails["details"]);?>
    </p>
    <fieldset>
      <legend>Update Ticket</legend>
      <p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
      <p>
        //TODO UPDATE TICKET CONTROLS & FORM
      </p>
    </fieldset>

</div>
