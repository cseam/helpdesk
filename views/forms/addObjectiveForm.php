<form action="#" method="post" id="addobjective" class="addobjectiveform">
<fieldset>
  <legend>Add Performance Objective</legend>
  <label for="assignto">Assign to</label>
    <select id="assignto" name="assignto" required>
      <option value="" SELECTED>Please Select</option>
      <?php foreach ($pagedata->engineers as $key => $value) { echo "<option value=\"".$value["idengineers"]."\">".$value["engineerName"]."</option>";} ?>
    </select>
  <label for="title" title="title">Objective Title</label>
    <input type="text" id="title" name="title" value=""  required />
  <label for="datedue" title="date due (yyyy/mm/dd)">date due ISO format (yyyy/mm/dd)</label>
    <input type="date" id="datedue" name="datedue" value="<?php echo date("Y/m/d");?>"  required />
  <label for="details" title="objective details">Objective Details</label>
    <textarea name="details" id="details" rows="10" cols="40"  required></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Create</button>
</p>
</form>

<script type="text/javascript">
	$(function() {
		$("#addobjective").validate({
      rules: {
				datedue: {
					dateISO: true,
					}
			},
    });
	});
</script>
