<form action="#" method="post" enctype="multipart/form-data" id="assign" class="assignform">
<fieldset>
		<legend>Assign Ticket #<?php echo $pagedata->ticketid ?></legend>
		<label for="assignto">Assign to</label>
		<select id="assignto" name="assignto" required>
			<option value="" SELECTED>Please Select</option>
			<?php foreach ($pagedata->engineers as $key => $value) { echo "<option value=\"".$value["idengineers"]."\">".$value["engineerName"]."</option>";} ?>
		</select>
		<label for="reason">Reason</label>
		<textarea name="reason" id="reason" rows="10" cols="40"></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Assign</button>
</p>
</form>

<script type="text/javascript">
	$(function() {
		$("#assign").validate({});
	});
</script>
