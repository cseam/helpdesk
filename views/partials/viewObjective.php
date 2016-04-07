<div id="calldetails">

<pre>
  <?php print_r($pagedata) ?>
</pre>







  <h3 class="callbody"><?php echo $ticketDetails["title"];?></h3>

    <form action="/ticket/update/" method="post" enctype="multipart/form-data" id="updateForm">
      <input type="hidden" id="id" name="id" value="<?php echo $ticketDetails["callid"]; ?>" />
      <input type="hidden" id="contact_email" name="contact_email" value="<?php echo $ticketDetails["email"]; ?>" />
      <input type="hidden" id="button_value" name="button_value" value="" />
      <input type="hidden" id="details" name="details" value="<?php echo htmlspecialchars($ticketDetails["details"]);?>" />
      <fieldset>
        <legend>Update Ticket</legend>
        <p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
        <p><label for="attachment">Picture or Attachment</label><input type="file" name="attachment" accept="application/pdf,application/msword,image/*" style="background-color: transparent;" id="attachment"></p>
        <p><label for="callreason">Reason for issue</label>
          <select id="callreason" name="callreason" REQUIRED>
            <option value="" SELECTED>Please Select</option>
            <option value="0" >Test Value</option>
            <?php foreach ($callreasons as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["reason_name"]."</option>"; } ?>
          </select>
        </p>
        <p>
        <label for="quickresponse">Quick Response</label>
          <select id="quickresponse" name="quickresponse">
            <option value="" SELECTED>Please Select</option>
            <?php foreach ($quickresponse as $key => $value) { echo "<option value=\"".$value["quick_response"]."\">".$value["quick_response"]."</option>"; } ?>
          </select>
        </p>
      </fieldset>
      <fieldset>
        <legend>Ticket Controls</legend>
        <div class="buttons">
          <button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">Update</button>
        </div>
      </fieldset>
    </form>
    <script>
      $("#updateForm").validate();
    </script>
</div>
