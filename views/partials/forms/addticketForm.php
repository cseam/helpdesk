<h3>Add Ticket</h3>
<form action="/ticket/update/" method="post" enctype="multipart/form-data" id="addForm">
<input type="hidden" id="button_value" name="button_value" value="" />
	<fieldset>
		<legend>Contact details</legend>
			<label for="name" title="Contact name for this call">Your/Contact Name</label>
			<input type="text" id="name" name="name" value="<?php isset($pagedata->userProfile['contactName']) ? print($pagedata->userProfile['contactName']) : '' ?>"  required />
			<label for="contact_email" title="Contact email so engineer can comunicate">Contact Email</label>
			<input type="text" id="contact_email" name="contact_email" value="<?php isset($pagedata->userProfile['contactEmail']) ? print($pagedata->userProfile['contactEmail']) : '' ?>"  required />
			<label for="tel" title="Contact telephone so engineer can comunicate">Telephone / Mobile Number</label>
			<input type="text" id="tel" name="tel" value="<?php isset($pagedata->userProfile['contactTel']) ? print($pagedata->userProfile['contactTel']) : '' ?>" />
	</fieldset>
	<fieldset>
		<legend>Location of issue</legend>
			<label for="location" title="location of issue">Building</label>
			<?php
        $userProfileLocationId = isset($pagedata->userProfile['location']) ? $pagedata->userProfile['location'] : '';
      ?>
			<select id="location" name="location">
				<option value="" SELECTED>Please Select</option>
				<?php
          $optiongroup = null;
        foreach ($pagedata->location as $key => $value) {
          if ($optiongroup !== $value['optiongroup']) { echo "<optgroup label=\"".$value['optiongroup']."\">"; $optiongroup = $value['optiongroup']; };
          ?>
					<option value="<?php echo $value["id"] ?>" <?php if ($value["id"] == $userProfileLocationId) { echo "SELECTED"; } ?>><?php echo $value["locationName"] ?></option>
				<?php
          if ($optiongroup !== $value['optiongroup']) { echo "</optgroup>"; };
        } ?>
			</select>
			<label for="room" title="Room where issue is">Room or Place</label>
			<input type="text" id="room" name="room" value="" />
	</fieldset>
	<fieldset>
		<legend>Scope of issue</legend>
			<label for="callurgency" title="how the issue effects me">Urgency</label>
			<select id="callurgency" name="callurgency">
				<option value="1" SELECTED>None</option>
				<option value="3">Minor</option>
				<option value="5">Low</option>
				<option value="6">Moderate</option>
				<option value="7">High</option>
				<option value="8">Very High</option>
				<option value="10">Dangerous</option>
			</select>
			<label for="callseverity" title="how the issue effects me">Severity</label>
			<select id="callseverity" name="callseverity">
				<option value="1" SELECTED>Alternative is available</option>
				<option value="1">Affects me</option>
				<option value="1">Affects me and my department</option>
				<option value="2">Affects multiple departments</option>
				<option value="3">Affects teaching and learning</option>
				<option value="3">Affects students</option>
				<option value="3">Affects my work</option>
				<option value="10">Affects all of College, houses and all facilities</option>
				<option value="5">Affects main College site only</option>
				<option value="5">Affects the boarding houses only</option>
				<option value="5">Affects catering or kitchens</option>
				<option value="5">Affects the Sports Centre facilities</option>
				<option value="5">Affects the Parabola Arts Centre facilities</option>
				<option value="6">Issue is time critical</option>
			</select>
			<script type="text/javascript">
				$("#callseverity").change(function(e) {
					if ($("#callseverity").val() == 6) {
						$("#timecritical").slideDown();
					} else {
						$("#timecritical").slideUp();
					}
				});
			</script>
			<div id="timecritical" style="display: none;">
				<label for="timerequired" title="time this required for?">Time required for?</label>
				<input type="text" id="timerequired" name="timerequired" value="" />
			</div>

	</fieldset>
	<fieldset>
		<legend>Department</legend>
			<label for="helpdesk" title="select the college department">Report to this Department</label>
			<select id="helpdesk" name="helpdesk" required>
				<option value="" SELECTED>Please Select</option>
				<?php foreach ($pagedata->helpdesks as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["helpdesk_name"]."</option>"; } ?>
			</select>
			<script type="text/javascript">
				$("#helpdesk").change(function(e) {
					$.post('/ticket/category/' + $("#helpdesk").val(), $(this).serialize(), function(resp){
						$('#category option').remove();
						$('#category').html(resp);
					});
					$.post('/ticket/description/' + $("#helpdesk").val(), $(this).serialize(), function(resp) {
						$('#helpdesk_description').hide();
						$('#helpdesk_description').html(resp);
						$('#helpdesk_description').slideDown();
					});
					e.preventDefault();
					return false;
				});
			</script>
			<div id="helpdesk_description"></div>
	</fieldset>
	<fieldset>
		<legend>Details of problem</legend>
			<label for="category" title="what type of issue do you have?">Type of issue</label>
			<select id="category" name="category">
				<option value="" SELECTED>Please select department first</option>
			</select>
			<script type="text/javascript">
							$("#category").change(function(e) {
								$.post('/ticket/additional/' + $("#category").val(), $(this).serialize(), function(resp) {
									$('#additional_fields').hide();
									$('#additional_fields').html(resp);
									$('#additional_fields').slideDown();
								});
								e.preventDefault();
								return false;
							});
			</script>
			<div id="additional_fields"></div>
			<label for="title" title="short one line title of your problem">Short description of issue (Title)</label>
			<input type="text" id="title" name="title" value="" required />
			<label for="updatedetails" title="enter the full details of your problem">Describe issue in detail</label>
			<textarea name="updatedetails" id="updatedetails" rows="10" cols="40"  required></textarea>
	</fieldset>
	<fieldset>
		<legend>Attachments (optional)</legend>
			<label for="attachment" title="add attachments if required">Picture or Screenshot</label>
			<input type="file" name="attachment" accept="application/pdf,application/msword,image/jpeg,image/png" id="attachment">
			<span id="preview" style="display: none;">
				<label>Attachment Image Preview</label>
				<img id="imgPreview" src="#" style="max-width:200px;min-height:100px;min-width:100px;border:1px solid silver;background:#eee; padding: 15px;" />
				<p id="imageClear" class="hyperbutton" style="display: block; margin: 0">Remove Attachment</p>
			</span>
			<script type="text/javascript">
			$(function() {
				// Wait for DOM ready state
				function previewImg(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#imgPreview').attr('src', e.target.result);
						}
						reader.readAsDataURL(input.files[0]);
					}
				}
				$("#attachment").change(function() { previewImg(this); $("#preview").slideDown(); });
				$("#imageClear").on('click', function() { $("#attachment").val(""); $("#preview").slideUp(); });
			});
			</script>
	</fieldset>
	<?php if ($_SESSION['engineerId'] !== null) {?>
		<input type="hidden" name="engineerid" id="engineerid" value="<?php echo $_SESSION['engineerId']; ?>" />
		<fieldset>
			<legend>Engineer Controls</legend>
				<table>
					<tr>
						<td><label for="cmn-toggle-selfassign" title="assign call to myself">Assign ticket to myself</label></td>
						<td><input type="checkbox" name="cmn-toggle-selfassign" id="cmn-toggle-selfassign" value="<?php echo $_SESSION['engineerId']; ?>"></td>
					</tr>
					<tr>
						<td><label for="cmn-toggle-retro" title="open call closed work already complete" >Instantly close ticket</label></td>
						<td><input type="checkbox" name="cmn-toggle-retro" id="cmn-toggle-retro" value="1"></td>
					</tr>
					<tr>
						<td><label for="cmn-toggle-pm" title="Planned preemptive maintance" >Planned Maintenance</label></td>
						<td><input type="checkbox" name="cmn-toggle-pm" id="cmn-toggle-pm" value="1"></td>
					</tr>
				</table>
		</fieldset>
	<?php }; ?>
	<p class="buttons">
		<button name="add" value="add" type="submit" title="add" onclick="this.form.button_value.value = this.value;">Submit</button>
	</p>
</form>
<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state
		// Client side form validation
		$("#addForm").validate({
			rules: {
				contact_email: {
					required: true,
					email: true
					},
				location: {
					required: true,
					},
				category: {
					required: true,
					}
				}
			});
		});
</script>
