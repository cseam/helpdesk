<form action="#" method="post" id="addoutofhours" class="addoutofhoursform">
  <fieldset>
  	<legend>Call Details</legend>
  		<label for="name" title="Engineer Contact">Engineer Called</label>
  		<input type="text" id="name" name="name" value="<?php echo $_SESSION['sAMAccountName'];?>"  required />
  		<label for="dateofcall" title="Date of call">Date of call (dd/mm/yy)</label>
  		<input type="text" id="dateofcall" name="dateofcall" value="<?php echo date("d/m/y");?>"  required />
  		<label for="timeofcall" title="Time of call">Time of call (24h hh:mm)</label>
  		<input type="text" id="timeofcall" name="timeofcall" value="<?php echo date("H:i");?>"  required />
  		<label for="calloutby" title="Call out by">Call out by</label>
  		<input type="text" id="calloutby" name="calloutby" value=""  required />
  		<label for="problem" title="problem">Description of problem</label>
  		<textarea name="problem" id="problem" rows="10" cols="40"  required></textarea>
  </fieldset>
  <fieldset>
  	<legend>Pre Site Visit</legend>
  		<label for="previsit" title="previsit">Description of Remote investigation (if any)</label>
  		<textarea name="previsit" id="previsit" rows="10" cols="40"></textarea>
  </fieldset>
  <fieldset>
  	<legend>Onsite Visit</legend>
  		<label for="timeonsite" title="Time on site">Time arrived on site (24h hh:mm)</label>
  		<input type="text" id="timeonsite" name="timeonsite" value="<?php echo date("H:i");?>" />
  		<label for="timeleftsite" title="Time left site">Time left site (24h hh:mm)</label>
  		<input type="text" id="timeleftsite" name="timeleftsite" value="<?php echo date("H:i");?>" />
  		<label for="locations" title="Locations Visited">Locations Visited</label>
  		<input type="text" id="locations" name="locations" value="" />
  		<label for="resolution" title="resolution">Description of Problem and Resolution</label>
  		<textarea name="resolution" id="resolution" rows="10" cols="40"></textarea>
  </fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Create</button>
</p>
</form>

<script type="text/javascript">
  $(function() {
    $("#addoutofhours").validate({});
  });
</script>
