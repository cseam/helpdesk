<form action="#" method="post" id="addscheduledtask" class="addscheduledtask">
  <fieldset>
    <legend>Frequency</legend>
      <label for="reoccurance" title="reoccurance">Reoccurance</label>
        <select id="reoccurance" name="reoccurance">
          <option value="once" >Once</option>
          <option value="daily" >Daily</option>
          <option value="weekly" SELECTED >Weekly</option>
          <option value="monthly" >Monthly</option>
          <option value="spring">Spring Term</option>
          <option value="summer">Summer Term</option>
          <option value="winter">Winter Term</option>
          <option value="yearly" >Yearly</option>
          <option value="bi-annual">bi-annual</option>
        </select>
      <label for="starton" title="Start On">Starting On (yyyy/mm/dd)</label>
        <input type="date" id="starton" name="starton" value="<?php echo date("Y/m/d"); ?>" />
      <label for="assigned" title="assigned">Assign to</label>
        <select id="assigned" name="assigned">
          <optgroup label="Global">
            <option value="DONT" SELECTED>Dont Assign (Manager can assign at later date)</option>
            <option value="AUTO" >Auto Assign</option>
          </optgroup>
          <optgroup label="Assign to engineer">
            <?php foreach ($pagedata->engineers as $key => $value) { echo "<option value=\"".$value["idengineers"]."\">".$value["engineerName"]."</option>"; } ?>
          </optgroup>
        </select>
  </fieldset>
  <input type="hidden" id="button_value" name="button_value" value="" />
  	<fieldset>
  		<legend>Contact details</legend>
  			<label for="name" title="Contact name for this call">Your/Contact Name</label>
  			<input type="text" id="name" name="name" value=""  required />
  			<label for="contact_email" title="Contact email so engineer can comunicate">Contact Email</label>
  			<input type="text" id="contact_email" name="contact_email" value="<?php echo $_SESSION['sAMAccountName']."@".COMPANY_SUFFIX; ?>"  required />
  			<label for="tel" title="Contact telephone so engineer can comunicate">Telephone / Mobile Number</label>
  			<input type="text" id="tel" name="tel" value="" />
  	</fieldset>
  	<fieldset>
  		<legend>Location of issue</legend>
  			<label for="location" title="location of issue">Building</label>
  			<select id="location" name="location">
  				<option value="" SELECTED>Please select</option>
  				<?php foreach ($pagedata->location as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["locationName"]."</option>"; } ?>
  			</select>
  			<label for="room" title="Room where issue is">Room or Place</label>
  			<input type="text" id="room" name="room" value="" />
  	</fieldset>
  	<fieldset>
  		<legend>Scope of issue</legend>
  			<label for="callurgency" title="how the issue effects me">Urgency</label>
  			<select id="callurgency" name="callurgency">
  				<option value="1" SELECTED>None</option>
  				<option value="3">Minor</option>
  				<option value="5">Low</option>
  				<option value="6">Moderate</option>
  				<option value="7">High</option>
  				<option value="8">Very High</option>
  				<option value="10">Dangerous</option>
  			</select>
  			<label for="callseverity" title="how the issue effects me">Severity</label>
  			<select id="callseverity" name="callseverity">
  				<option value="1" SELECTED>Alternative is available</option>
  				<option value="1">Affects me</option>
  				<option value="1">Affects me and my department</option>
  				<option value="2">Affects multiple departments</option>
  				<option value="3">Affects teaching and learning</option>
  				<option value="3">Affects students</option>
  				<option value="3">Affects my work</option>
  				<option value="10">Affects all of College, houses and all facilities</option>
  				<option value="5">Affects main College site only</option>
  				<option value="5">Affects the boarding houses only</option>
  				<option value="5">Affects catering or kitchens</option>
  				<option value="5">Affects the Sports Centre facilities</option>
  				<option value="5">Affects the Parabola Arts Centre facilities</option>
  				<option value="6">Issue is time critical</option>
  			</select>
  	</fieldset>
  	<fieldset>
  		<legend>Department</legend>
  			<label for="helpdesk" title="select the college department">Report to this Department</label>
  			<select id="helpdesk" name="helpdesk" required>
  				<option value="" SELECTED>Please Select</option>
  				<?php foreach ($pagedata->helpdesks as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["helpdesk_name"]."</option>"; } ?>
  			</select>
  			<script type="text/javascript">
  				$("#helpdesk").change(function(e) {
  					$.post('/ticket/category/' + $("#helpdesk").val(), $(this).serialize(), function(resp){
  						$('#category option').remove();
  						$('#category').html(resp);
  					});
  					$.post('/ticket/description/' + $("#helpdesk").val(), $(this).serialize(), function(resp) {
  						$('#helpdesk_description').hide();
  						$('#helpdesk_description').html(resp);
  						$('#helpdesk_description').slideDown();
  					});
  					e.preventDefault();
  					return false;
  				});
  			</script>
  			<div id="helpdesk_description"></div>
  	</fieldset>
  	<fieldset>
  		<legend>Details of problem</legend>
  			<label for="category" title="what type of issue do you have?">Type of issue</label>
  			<select id="category" name="category">
  				<option value="" SELECTED>Please select department first</option>
  			</select>
  			<script type="text/javascript">
  							$("#category").change(function(e) {
  								$.post('/ticket/additional/' + $("#category").val(), $(this).serialize(), function(resp) {
  									$('#additional_fields').hide();
  									$('#additional_fields').html(resp);
  									$('#additional_fields').slideDown();
  								});
  								e.preventDefault();
  								return false;
  							});
  			</script>
  			<div id="additional_fields"></div>
  			<label for="title" title="short one line title of your problem">Short description of issue (Title)</label>
  			<input type="text" id="title" name="title" value="" required />
  			<label for="details" title="enter the full details of your problem">Describe issue in detail</label>
  			<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
  	</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Create</button>
</p>
</form>

<script type="text/javascript">
  $(function() {
    $("#addscheduledtask").validate({
      rules: {
				reoccurance: {
					required: true
				},
				starton: {
					required: true,
					date: true
				},
				assigned: {
					required: true
				},
				email: {
					required: true,
					email: true
					},
				location: {
					required: true,
					},
				category: {
					required: true,
					}
				}
    });
  });
</script>
