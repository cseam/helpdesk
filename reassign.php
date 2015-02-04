<?php 
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');
?>
<script src="/javascript/jquery.validate.min.js" type="text/javascript"></script>
<form action="updatecall.php" method="post" enctype="multipart/form-data" id="reassign">
	<h3>Reassign Call</h3>
	<fieldset>
		<legend>Helpdesk Call #<?php echo($_POST['id']);?></legend>
		<input type="hidden" id="id" name="id" value="<?php echo($_POST['id']);?>" />
		<label for="helpdesk">Assign to</label>
			<select id="engineer" name="engineer" required>
				<option value="" SELECTED>Please Select</option>
				<?php
				if ($_SESSION['engineerHelpdesk'] <= '3') {
					$whereenginners = 'WHERE helpdesk <= 3';	
				} else {
					$whereenginners = 'WHERE helpdesk='.$_SESSION['engineerHelpdesk'];				
				};	
				$helpdesks = mysqli_query($db, "SELECT * FROM engineers " .$whereenginners. " ORDER BY engineerName");
				while($option = mysqli_fetch_array($helpdesks)) { ?>
					<option value="<?php echo($option['idengineers']);?>"><?php echo($option['engineerName']);?></option>
				<?php }; ?>
			</select>
		<label for="details">Reason</label>
		<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
	</fieldset>
	<p class="buttons">
		<button name="reassign" value="reassign" type="submit">Reassign</button>
	</p>
</form>
<script type="text/javascript">
		$("#reassign").validate();
</script>