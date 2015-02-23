<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Add Ticket</h3>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="addForm">
	<fieldset>
		<legend>Your contact details</legend>
			<label for="name" title="Contact name for this call">Your Name</label>
			<input type="text" id="name" name="name" value="<?php echo $_SESSION['sAMAccountName'];?>"  required />
			<label for="email" title="Contact email so engineer can comunicate">Your Email</label>
			<input type="text" id="email" name="email" value="<?php echo $_SESSION['sAMAccountName']."@". COMPANY_SUFFIX;?>"  required />
			<label for="tel" title="Contact telephone so engineer can comunicate">Telephone / Mobile Number</label>
			<input type="text" id="tel" name="tel" value=""  required />
	</fieldset>
	<fieldset>
		<legend>Location of issue</legend>
			<label for="location" title="location on campus of issue">Location on campus</label>
			<select id="location" name="location">
				<option value="" SELECTED>Please Select</option>
					<?php
						$locations = mysqli_query($db, "SELECT * FROM location ORDER BY locationName;");
							while($option = mysqli_fetch_array($locations))  { ?>
								<option value="<?php echo $option['id'];?>"><?php echo $option['locationName'];?></option>
					<? }; ?>
			</select>
			<label for="room" title="Room where issue is">Room or Place</label>
			<input type="text" id="room" name="room" value="" />
	</fieldset>
	<fieldset>
		<legend>Scope of issue</legend>
			<label for="callurgency" title="how the issue effects me">Urgency</label>
			<select id="callurgency" name="callurgency">
				<option value="1">An alternative is available</option>
				<option value="2">This is affecting my work</option>
				<option value="3">I cannot work</option>
			</select>
			<label for="callseverity" title="how the issue effects me">Severity</label>
			<select id="callseverity" name="callseverity">
				<option value="1">This problem affects only me</option>
				<option value="2">This problem affects multiple people</option>
				<option value="3">This problem affects all of College and boarding houses</option>
			</select>
	</fieldset>
	<fieldset>
		<legend>Department</legend>
			<label for="helpdesk" title="select the college department">Report to this department</label>
			<select id="helpdesk" name="helpdesk" required>
				<option value="" SELECTED>Please Select</option>
					<?php
					$helpdesks = mysqli_query($db, "SELECT * FROM helpdesks ORDER BY helpdesk_name");
						while($option = mysqli_fetch_array($helpdesks)) { ?>
							<option value="<?php echo $option['id'];?>"><?php echo $option['helpdesk_name'];?></option>
					<?php }; ?>
			</select>
			<script type="text/javascript">
				$("#helpdesk").change(function(e) {
				$.post('/includes/partial/form/helpdesk_description.php?id=' + $("#helpdesk").val(), $(this).serialize(), function(resp) {
					$('#helpdesk_description').hide();
					$('#helpdesk_description').html(resp);
					$('#helpdesk_description').slideDown();
				});
				e.preventDefault();
				$('#category :not(.helpdesk-' + $("#helpdesk").val() +' )').remove();
				return false;
				});
			</script>
			<div id="helpdesk_description"></div>
	</fieldset>
	<fieldset>
		<legend>Details of problem</legend>
			<label for="category" title="what type of issue do you have?">Type of issue</label>
			<select id="category" name="category">
				<option value="" SELECTED>Please Select</option>
					<?php
					$categories = mysqli_query($db, "SELECT * FROM categories ORDER BY categoryName;");
						while($option = mysqli_fetch_array($categories))  { ?>
							<option value="<?php echo $option['id'];?>" class="helpdesk-<?php echo $option['helpdesk'];?>"><?php echo $option['categoryName'];?></option>
					<?php }; ?>
			</select>
			<script type="text/javascript">
				$("#category").change(function(e) {
					$.post('/includes/partial/form/additional_fields.php?id=' + $("#category").val(), $(this).serialize(), function(resp) {
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
			<label for="details" title="enter the full details of your problem">Describe issue in detail</label>
			<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
	</fieldset>
	<fieldset>
		<legend>Attachments (optional)</legend>
			<label for="attachment" title="add attachments if required">Picture or Screenshot</label>
			<input type="file" name="attachment" accept="image/*">
	</fieldset>

	<?php if ($_SESSION['engineerId'] !== null) {?>
	<fieldset>
		<legend>Engineer Controls</legend>
			<table>
				<tr>
					<td style="border-bottom: 0;">
						<label for="cmn-toggle-selfassign" title="assign call to myself" style="width: 200px; padding: 4px 0;">Assign ticket to myself</label>
						<input type="checkbox" name="cmn-toggle-selfassign" id="cmn-toggle-selfassign" value="<?php echo $_SESSION['engineerId'];?>" class="cmn-toggle cmn-toggle-round"><label for="cmn-toggle-selfassign"></label>
					</td>
					<td style="border-bottom: 0;">
						<label for="cmn-toggle-retro" title="open call closed work already complete" style="width: 200px; padding: 4px 0;">Instantly close ticket</label>
						<input type="checkbox" name="cmn-toggle-retro" id="cmn-toggle-retro" value="1" class="cmn-toggle cmn-toggle-round">
						<label for="cmn-toggle-retro"></label>
					</td>
				</tr>
			</table>
	</fieldset>
	<?php }; ?>

	<p class="buttons">
		<button name="submit" value="submit" type="submit" title="Submit">Submit</button>
		<button name="clear" value="clear" type="reset" title="Clear">Clear</button>
	</p>
</form>
<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state

		// Client side form validation
		$("#addForm").validate({
			rules: {
				email: {
					required: true,
					email: true
					},
				location: {
					required: true,
					},
				category: {
					required: true,
					}
				},
			// Submit via ajax if valid
			submitHandler: function(form) {

				// Setup formdata object
				var formData = new FormData(document.getElementById("addForm"));
				// Main magic with files here
				formData.append('attachment', $('input[type=file]')[0].files[0]);
				console.log(formData);

				$.ajax(
					{
					type: 'post',
					url: '/includes/partial/post/add_ticket.php',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data)
					{
						$('#ajax').html(data);
						console.log ("added new ticket");
					},
					error: function()
					{
						$('#ajax').html('error :' + error() );
						console.log ("add ticket failed");
					}
				});
			}
		});

	// End DOM Ready
	});
</script>