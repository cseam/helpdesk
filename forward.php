<?php session_start();?>
<?php
	// load functions
	include_once 'includes/functions.php';
?>
<script src="javascript/jquery.validate.min.js" type="text/javascript"></script>
<form action="updatecall.php" method="post" enctype="multipart/form-data" id="forward">
<input type="hidden" id="id" name="id" value="<?=$_POST['id'];?>" />
<h3>Forward Call</h3>
<fieldset>
<legend>Helpdesk Call #<?=$_POST['id'];?></legend>

<label for="fwdhelpdesk">forward #<?=$_POST['id'];?> call to</label>
	<select id="fwdhelpdesk" name="fwdhelpdesk" required>
				<option value="" SELECTED>Please Select</option>
				<?php
				$helpdesks = mysqli_query($db, "SELECT * FROM helpdesks");
				while($option = mysqli_fetch_array($helpdesks)) { ?>
					<option value="<?=$option['id'];?>"><?=$option['helpdesk_name'];?></option>
				<? } ?>
	</select>
<label for="details">Reason</label>
			<textarea name="details" id="details" rows="10" cols="40"  required></textarea>

</fieldset>
<p class="buttons">
		<button name="reassign" value="reassign" type="submit">Forward Call</button>
</p>
</form>
<script type="text/javascript">
		$("#forward").validate();
</script>
