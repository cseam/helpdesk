<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="forward">
<input type="hidden" id="id" name="id" value="<?php echo($_POST['id']);?>" />
	<h3>Forward Ticket</h3>
		<fieldset>
		<legend><?php echo(CODENAME);?> ticket #<?php echo($_POST['id']);?></legend>
			<label for="fwdhelpdesk">forward #<?php echo($_POST['id']);?> ticket to</label>
			<select id="fwdhelpdesk" name="fwdhelpdesk" required>
				<option value="" SELECTED>Please Select</option>
				<?php
				$STH = $DBH->Prepare('SELECT * FROM helpdesks');
				$STH->setFetchMode(PDO::FETCH_OBJ);
				$STH->execute();
				while($row = $STH->fetch()) { ?>
					<option value="<?php echo($row->id); ?>"><?php echo($row->helpdesk_name); ?></option>
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
	$(function() {
		// Wait for DOM ready state

		// Client side form validation
		$("#forward").validate({
			// Submit via ajax if valid
			submitHandler: function(form) {
				$.ajax(
					{
					type: 'post',
					url: '/includes/partial/post/update_ticket.php',
					data: $('#forward').serialize(),
					success: function(data)
					{
						$('#ajax').html(data);
						console.log ("update ticket");
					},
					error: function()
					{
						$('#ajax').html('error :' + error() );
						console.log ("update failed");
					}
				});
			}
		});

	// End DOM Ready
	});
</script>