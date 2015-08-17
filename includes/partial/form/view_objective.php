<?php
	// start sessions
	session_start();
	//load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// check if authenticated
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	// post passes over ticket id once ticket id is passed populate page
	if ($_SERVER['REQUEST_METHOD']== "POST") {
		//populate ticket details from db
		$STH = $DBH->Prepare("SELECT * FROM performance_review_objectives
		WHERE id = :id");
		$STH->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		while($row = $STH->fetch()) { ?>

<div id="calldetails">
	<form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" id="updateForm">
		<input type="hidden" id="id" name="id" value="<?php echo($row->id);?>" />
		<input type="hidden" id="button_value" name="button_value" value="" />
		<input type="hidden" id="details" name="details" value="<?php echo($row->details);?>" />
		
		<h2>Performance Objective</h2>
		<p class="callheader">due date <?php echo(date("M Y", strtotime($row->datedue))); ?></p>
		<p class="callheader">progress <?php echo($row->progress); ?>%</p>
		<p class="callheader">for <?php echo(engineer_friendlyname($row->engineerid)); ?></p>
		<h3 class="callbody"><?php echo($row->title);?></h3>
		<p class="callbody"><?php echo(nl2br($row->details));?></p>
	
	<fieldset>
		<legend>Update On My Progress</legend>
		<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
		<label for="progress">Progress</label>
				<select id="progress" name="progress" REQUIRED>
					<option value="" SELECTED>Please Select</option>
					<option value="5">5%</option>
					<option value="10">10%</option>
					<option value="15">15%</option>
					<option value="20">20%</option>
					<option value="25">25%</option>
					<option value="30">30%</option>
					<option value="35">35%</option>
					<option value="40">40%</option>
					<option value="45">45%</option>
					<option value="50">50%</option>
					<option value="55">55%</option>
					<option value="60">60%</option>
					<option value="65">65%</option>
					<option value="70">70%</option>
					<option value="75">75%</option>
					<option value="80">80%</option>
					<option value="85">85%</option>
					<option value="90">90%</option>
					<option value="95">95%</option>
					<option value="100">100%</option>
				</select>
	</fieldset>	
	<fieldset>	
		<legend>Update Controls</legend>
			<p class="buttons">
			<button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">Update</button>
			</p>
	</fieldset>
	</form>
	<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state

		// Client side form validation
		$("#updateForm").validate({
			rules: {
				updatedetails: {
					required: false,
					}
			},
			// Submit via ajax if valid
			submitHandler: function(form) {

				// Setup formdata object
				var formData = new FormData(document.getElementById("updateForm"));
				// Main magic with files here
				console.log(formData);

				$.ajax(
					{
					type: 'post',
					url: '/includes/partial/post/update_objective.php',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data)
					{
						$('#ajax').html(data);
						console.log ("updated objective");
					},
					error: function()
					{
						$('#ajax').html('error :' + error() );
						console.log ("error updating objective");
					}
				});
			}
		});
		// End DOM Ready
	});
	</script>



</div>
<?php
	
// close while loop
};
// close method post
};