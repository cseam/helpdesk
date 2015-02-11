<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<script src="/javascript/jquery.validate.min.js" type="text/javascript"></script>
<form action="updatecall.php" method="post" enctype="multipart/form-data" id="forward">
<input type="hidden" id="id" name="id" value="<?php echo($_POST['id']);?>" />
	<h3>Forward Ticket</h3>
		<fieldset>
		<legend><?php echo(CODENAME);?> ticket #<?php echo($_POST['id']);?></legend>
			<label for="fwdhelpdesk">forward #<?php echo($_POST['id']);?> ticket to</label>
			<select id="fwdhelpdesk" name="fwdhelpdesk" required>
				<option value="" SELECTED>Please Select</option>
				<?php
				$helpdesks = mysqli_query($db, "SELECT * FROM helpdesks");
				while($option = mysqli_fetch_array($helpdesks)) { ?>
					<option value="<?php echo($option['id']);?>"><?php echo($option['helpdesk_name']);?></option>
				<?php }; ?>
			</select>
			<label for="details">Reason</label>
			<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
		</fieldset>
		<p class="buttons">
			<button name="forward" value="forward" type="submit">Forward Ticket</button>
		</p>
</form>
<script type="text/javascript">
		$("#forward").validate();
</script>