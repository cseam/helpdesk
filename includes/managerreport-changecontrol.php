<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>
<p>Please log all changes to servers, and tag appropriately.</p>
<script src="javascript/jquery.validate.min.js" type="text/javascript"></script>
<form action="" method="post" enctype="multipart/form-data" id="changecontrol">
<fieldset>
	<legend>add change control</legend>
	<label for="">Date / Time</label>
		<input type="text" id="name" name="name" value=""  required />
	<label for="">Engineer</label>
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
					<option value="<?=$option['idengineers'];?>"><?=$option['engineerName'];?></option>
				<? } ?>
		</select>	
	<label for="">Change</label>
		<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
	<label for="">Tags</label>
		<input type="text" id="name" name="name" value="" readonly="true" required />
	<p class="tags">
		<button name="add" value="add" type="submit">internet</button>
		<button name="add" value="add" type="submit">wireless</button>
		<button name="add" value="add" type="submit">dhcp</button>
		<button name="add" value="add" type="submit">group policy</button>
		<button name="add" value="add" type="submit">updates</button>
	</p>
	<p class="buttons">
		<button name="add" value="add" type="submit">Submit</button>
	</p>	
</fieldset>
</form>
<h3>History</h3>

<script type="text/javascript">
		$("#reassign").validate();
</script>
