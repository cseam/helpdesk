<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>
<h3>Current Tags</h3>
<p class="tags">
		<?
			$tags = mysqli_query($db, "SELECT * FROM changecontrol_tags;");
				while($buttons = mysqli_fetch_array($tags)) { ?>
					<button name="tag" value="<?=$buttons['tagname'];?>" type="submit"><?=$buttons['tagname'];?></button>
		<? } ?>
</p>
<fieldset>
<legend>Add New Tag</legend>
<label for="">Tag name</label>
		<input type="text" id="tagname" name="tagname" value=""  required />
	<p class="buttons">
		<button name="add" value="add" type="submit">Submit</button>
	</p>	
</fieldset>


