<form action="#" method="post" id="modifyobjective" class="modifyobjectiveform">
<fieldset>
  <legend>Modify Performance Objective</legend>
  <label for="title" title="title">Objective Title</label>
    <input type="text" id="title" name="title" value="<?php echo $pagedata->objectivedetails[0]['title']; ?>"  required />
  <label for="datedue" title="date due (yyyy/mm/dd)">date due ISO format (yyyy/mm/dd)</label>
    <input type="date" id="datedue" name="datedue" value="<?php echo date("Y/m/d", strtotime($pagedata->objectivedetails[0]['datedue']) );?>"  required />
  <label for="details" title="objective details">Objective Details</label>
    <textarea name="details" id="details" rows="10" cols="40"  required><?php echo strip_tags($pagedata->objectivedetails[0]['details']); ?></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Update</button>
</p>
</form>

<script type="text/javascript">
	$(function() {
		$("#modifyobjective").validate({
      rules: {
				datedue: {
					dateISO: true,
					}
			},
    });
	});
</script>
