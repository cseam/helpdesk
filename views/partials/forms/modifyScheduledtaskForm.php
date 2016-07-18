<form action="#" method="post" id="addchangecontrol" class="addchangecontrolform">
<fieldset>
  <legend>Add Change Control</legend>
  <label for="servername">Server Name</label>
  <input type="text" id="servername" name="servername" required/>
  <label for="details">Change Made</label>
  <textarea name="details" id="details" rows="10" cols="40" required></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Create</button>
</p>
</form>

<script type="text/javascript">
  $(function() {
    $("#addchangecontrol").validate({});
  });
</script>
