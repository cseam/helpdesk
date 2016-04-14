<form action="#" method="post" enctype="multipart/form-data" id="forward" class="forwardform">
<fieldset>
		<legend>Forward Ticket #<?php echo $ticketid ?></legend>
		<label for="fwdhelpdesk">forward to</label>
		<select id="fwdhelpdesk" name="fwdhelpdesk" required>
			<option value="" SELECTED>Please Select</option>
			<?php foreach ($helpdesks as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["helpdesk_name"]."</option>";} ?>
		</select>
		<label for="reason">Reason</label>
		<textarea name="reason" id="reason" rows="10" cols="40"></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Forward</button>
</p>
</form>

<script type="text/javascript">
	$(function() {
		$("#forward").validate({});
	});
</script>
