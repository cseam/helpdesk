<?php if ($pagedata->errorMessage) {
  echo $pagedata->errorMessage;
} else { ?>


<div id="calldetails">
<h2>Performance Objective #<?php echo $pagedata->reportResults[0]['id'] ?></h2>
<p class="callheader"><span class="nowrap">Due by:</span>       <span class="nowrap"><?php echo $pagedata->reportResults[0]['datedue'] ?></span></p>
<p class="callheader"><span class="nowrap">Progress:</span>       <span class="nowrap"><?php echo $pagedata->reportResults[0]['progress'] ?>%</span></p>
<h3 class="callbody"><?php echo $pagedata->reportResults[0]['title'] ?></h3>
<p class="callbody"><?php echo $pagedata->reportResults[0]['details'] ?></p>

<form action="#" method="post" enctype="multipart/form-data" id="updateForm">
  <input type="hidden" id="id" name="id" value="<?php echo $pagedata->reportResults[0]['id']; ?>" />
  <input type="hidden" id="button_value" name="button_value" value="" />
  <fieldset>
    <legend>Update Performance Objective</legend>
    <p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40" REQUIRED></textarea></p>
    <p><label for="progress">Objective Progress %</label>
          <select id="progress" name="progress" REQUIRED>
            <option value="" SELECTED>Please Select</option>
            <option value="0" >0%</option>
            <option value="5" >5%</option>
            <option value="10" >10%</option>
            <option value="15" >15%</option>
            <option value="20" >20%</option>
            <option value="25" >25%</option>
            <option value="30" >30%</option>
            <option value="35" >35%</option>
            <option value="40" >40%</option>
            <option value="45" >45%</option>
            <option value="50" >50%</option>
            <option value="55" >55%</option>
            <option value="60" >60%</option>
            <option value="65" >65%</option>
            <option value="70" >70%</option>
            <option value="75" >75%</option>
            <option value="80" >80%</option>
            <option value="85" >85%</option>
            <option value="90" >90%</option>
            <option value="95" >95%</option>
            <option value="100" >100%</option>
          </select>
    </p>
    <div class="buttons">
      <button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">Update</button>
      <?php if ($_SESSION['engineerLevel'] > 1 OR $_SESSION['superuser'] == true) { ?>
        <button name="modify" value="modify" type="submit" onclick="this.form.button_value.value = this.value;">Modify</button>
        <button name="delete" value="delete" type="submit" onclick="this.form.button_value.value = this.value;">Delete</button>
      <?php } ?>
    </div>
  </fieldset>
</form>
<script>
  $("#updateForm").validate();
</script>
</div>
<?php } ?>
