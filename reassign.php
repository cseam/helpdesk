<?php session_start();?>
<?php
	// load functions
	include_once 'includes/functions.php';
?>
<script src="javascript/jquery.validate.min.js" type="text/javascript"></script>
<form action="updatecall.php" method="post" enctype="multipart/form-data" id="reassign">
<h3>Reassign Call</h3>
<fieldset>
<legend>Helpdesk Call #<?=$_POST['id'];?></legend>

<input type="hidden" id="id" name="id" value="<?=$_POST['id'];?>" />

<label for="helpdesk">Assign to</label>
	<select id="engineer" name="engineer" required>
				<option value="" SELECTED>Please Select</option>
				<option value="1">Test item</option>
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



