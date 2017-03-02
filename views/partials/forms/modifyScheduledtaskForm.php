<form action="#" method="post" id="modifyScheduledtask" class="modifyScheduledtaskform">
<h3>Modify Task #<?php echo $pagedata->taskDetails["0"]["callid"] ?></h3>
<input type="hidden" id="callid" name="callid" value="<?php echo $pagedata->taskDetails["0"]["callid"] ?>" />
  <fieldset>
    <legend>Frequency</legend>
    <label for="enabled" title="enabled">Enabled</label>
      <select id="enabled" name="enabled">
        <option value="1" <?php if($pagedata->taskDetails["0"]["enabled"] == "1") {echo "SELECTED";} ?>>Yes</option>
        <option value="0" <?php if($pagedata->taskDetails["0"]["enabled"] == "0") {echo "SELECTED";} ?>>No</option>
      </select>
      <label for="reoccurance" title="reoccurance">Reoccurance</label>
        <select id="reoccurance" name="reoccurance">
          <option value="once" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "once") {echo "SELECTED";} ?>>Once</option>
          <option value="daily" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "daily") {echo "SELECTED";} ?>>Daily</option>
          <option value="weekly" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "weekly") {echo "SELECTED";} ?>>Weekly</option>
          <option value="monthly" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "monthly") {echo "SELECTED";} ?>>Monthly</option>
          <option value="spring" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "spring") {echo "SELECTED";} ?>>Spring Term</option>
          <option value="summer" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "summer") {echo "SELECTED";} ?>>Summer Term</option>
          <option value="winter" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "winter") {echo "SELECTED";} ?>>Winter Term</option>
          <option value="yearly" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "yearly") {echo "SELECTED";} ?>>Yearly</option>
          <option value="bi-annual" <?php if($pagedata->taskDetails["0"]["frequencytype"] == "bi-annual") {echo "SELECTED";} ?>>bi-annual</option>
        </select>
      <label for="starton" title="Start On">Starting On (yyyy-mm-dd)</label>
        <input id="starton" name="starton" value="<?php echo date("Y-m-d", strtotime($pagedata->taskDetails["0"]["startschedule"])) ?>" />
      <label for="assigned" title="assigned">Assign to</label>
        <select id="assigned" name="assigned">
          <optgroup label="Global">
            <option value="DONT" <?php if($pagedata->taskDetails["0"]["assigned"] == 0) {echo "SELECTED";} ?>>Dont Assign (Manager can assign at later date)</option>
            <option value="AUTO" <?php if($pagedata->taskDetails["0"]["assigned"] == -1) {echo "SELECTED";} ?>>Auto Assign</option>
          </optgroup>
          <optgroup label="Assign to engineer">
            <?php foreach ($pagedata->engineers as $key => $value) { echo "<option value=\"".$value["idengineers"]."\">".$value["engineerName"]."</option>"; } ?>
          </optgroup>
        </select>
  </fieldset>
  <fieldset>
    <legend>Details of problem</legend>
      <label for="title" title="short one line title of your problem">Short description of issue (Title)</label>
      <input type="text" id="title" name="title" value="<?php echo $pagedata->taskDetails["0"]["title"] ?>" required />
      <label for="details" title="enter the full details of your problem">Describe issue in detail</label>
      <textarea name="details" id="details" rows="10" cols="40"  required><?php echo strip_tags($pagedata->taskDetails["0"]["details"]) ?></textarea>
  </fieldset>

<p class="buttons">
	<button name="submit" value="submit" type="submit">Modify</button>
</p>
</form>

<script type="text/javascript">
  $(function() {
    $("#modifyScheduledtask").validate({});
  });
</script>
