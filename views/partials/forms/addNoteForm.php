<form action="#" method="post" enctype="multipart/form-data" id="noteForm" class="noteform">
<fieldset>
		<legend>Add Note</legend>
		<label for="note">Note</label>
		<textarea name="note" id="note" rows="10" cols="40"></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Add Note</button>
</p>
</form>

<script type="text/javascript">
	$(function() {
		$("#noteForm").validate({});
	});
</script>
