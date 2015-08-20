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

		//INNER JOIN engineers ON calls.assigned=engineers.idengineers

		$STH = $DBH->Prepare("SELECT * FROM calls
		INNER JOIN status ON calls.status=status.id
		INNER JOIN location ON calls.location=location.id
		INNER JOIN categories ON calls.category=categories.id
		WHERE callid = :callid");
		$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		while($row = $STH->fetch()) { ?>

<div id="calldetails">
	<form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" enctype="multipart/form-data" id="updateForm">
		<input type="hidden" id="id" name="id" value="<?php echo($row->callid);?>" />
		<input type="hidden" id="button_value" name="button_value" value="" />
		<input type="hidden" id="details" name="details" value="<?php echo($row->details);?>" />
		<h2>Ticket details #<?php echo($_POST['id']);?></h2>
		<p class="callheader">#<?php echo($_POST['id']);?> <?php if ($row->urgency === '3') { echo("urgent ");} ?></p>
		<p class="callheader"><?php echo($row->categoryName);?></p>
		<p class="callheader">Created by <?php echo($row->name);?></p>
		<p class="callheader">Contact number: <?php echo($row->tel);?></p>
		<p class="callheader"><?php echo($row->locationName);?></p>
		<p class="callheader"><?php echo($row->room);?></p>
		<p class="callheader"><?php if ($row->assigned == NULL) { echo("Not assigned yet"); } else {?>Assigned to <?php echo(engineer_friendlyname($row->assigned)); }?></p>
		<p class="callheader">
		<?php
		if ($row->status === '2') { echo("Closed in ");} else { echo("Open for ");};
			$date1 = strtotime($row->opened);
			if ($row->status ==='2') {$date2 = strtotime($row->closed);} else {$date2 = time();};
			$diff = $date2 - $date1;
			$d = ($diff/(60*60*24))%365;
			$h = ($diff/(60*60))%24;
			$m = ($diff/60)%60;
			echo( $d." days, ".$h." hours, ".$m." minutes");
		?>
		</p>
		<p class="callheader">Call Opened <?php echo(date("d/m/y h:i:s", strtotime($row->opened)));?></p>
		<p class="callheader">Last Update <?php echo(date("d/m/y h:i:s", strtotime($row->lastupdate)));?></p>
		<?php if ($row->lockerid != null) { ?><p class="callheader">Locker #<?php echo($row->lockerid);?></p><?php }; ?>
		<?php
			// populate additional fields
				$STHloop = $DBH->Prepare("SELECT * FROM call_additional_results WHERE callid = :callid");
				$STHloop->bindParam(':callid', $row->callid, PDO::PARAM_STR);
				$STHloop->setFetchMode(PDO::FETCH_OBJ);
				$STHloop->execute();
				while($row2 = $STHloop->fetch()) { ?>
					<p class="callheader"><?php echo($row2->label);?> - <?php echo($row2->value);?></p>
				<?php }; ?>
		<h3 class="callbody"><?php echo($row->title);?></h3>
		<p class="callbody"><?php echo(nl2br($row->details));?></p>
	<fieldset>
		<legend>Update Ticket</legend>
		<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
		<p><label for="attachment">Picture or Screenshot</label><input type="file" name="attachment" accept="image/*" style="background-color: transparent;" id="attachment"></p>
		<?php if ($_SESSION['engineerId'] !== null) {?>
	</fieldset>
	<fieldset>
		<legend>Engineer Controls</legend>
			<span class="engineercontrols">
				<label for="callreason">Reason for issue</label>
				<select id="callreason" name="callreason">
					<option value="" SELECTED>Please Select</option>
					<?php
						if ($_SESSION['engineerHelpdesk'] <= '3') {
							$STHloop = $DBH->Prepare("SELECT * FROM callreasons WHERE helpdesk_id <= :helpdeskid ORDER BY reason_name");
							$hdid = 3;
						} else {
							$STHloop = $DBH->Prepare("SELECT * FROM callreasons WHERE helpdesk_id = :helpdeskid ORDER BY reason_name");
							$hdid = $_SESSION['engineerHelpdesk'];
						}
						$STHloop->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
						$STHloop->setFetchMode(PDO::FETCH_OBJ);
						$STHloop->execute();
						while($row2 = $STHloop->fetch()) { ?>
						<option value="<?php echo($row2->id);?>"><?php echo($row2->reason_name);?></option>
					<?php }; ?>
				</select>
				<label for="quickresponse">Quick Response</label>
				<select id="quickresponse" name="quickresponse">
					<option value="" SELECTED>Please Select</option>
					<?php
						if ($_SESSION['engineerHelpdesk'] <= '3') {
							$STHloop = $DBH->Prepare("SELECT * FROM quick_responses WHERE helpdesk_id <= :helpdeskid ORDER BY quick_response");
							$hdid = 3;
						} else {
							$STHloop = $DBH->Prepare("SELECT * FROM quick_responses WHERE helpdesk_id = :helpdeskid ORDER BY quick_response");
							$hdid = $_SESSION['engineerHelpdesk'];
						}
						$STHloop->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
						$STHloop->setFetchMode(PDO::FETCH_OBJ);
						$STHloop->execute();
						while($row2 = $STHloop->fetch()) { ?>
						<option value="<?php echo($row2->quick_response);?>"><?php echo($row2->quick_response);?></option>
					<?php }; ?>
				</select>
				<script type="text/javascript">
					$("#quickresponse").change(function(e) {
						$('#updatedetails').val($('#quickresponse').val() + ', ' + $('#updatedetails').val());
					});
				</script>
			</span>
	</fieldset>
	<?php }; ?>
	<fieldset>
		<legend>Update Controls</legend>
			<p class="buttons">	
			<?php if ($row->status === '1') {?>
			
			<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?>
				<button name="assign" value="assign" type="submit" onclick="this.form.button_value.value = this.value;">assign</button>
			<?php }; ?>	
			
			
			
			<button name="sendaway" value="sendaway" type="submit" onclick="this.form.button_value.value = this.value;">Send Away</button>
			<button name="escalate" value="escalate" type="submit" onclick="this.form.button_value.value = this.value;">Escalate</button>
			<button name="hold" value="hold" type="submit" onclick="this.form.button_value.value = this.value;">Hold</button>
			<button name="close" value="close" type="submit" onclick="this.form.button_value.value = this.value;">Close</button>
			<?php };?>
			<?php if ($row->status === '2') {
				echo("<a href='". HELPDESK_LOC ."/views/feedback.php?id=" . $row->callid ."'>Leave Feedback</a> or");
			};?>
			<?php if ($row->status === '2') {?>
			<button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">still have an issue?</button>
			<?php } else { ?>
				<button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">Update</button>
			<?php }; ?>
			
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
				formData.append('attachment', $('input[type=file]')[0].files[0]);
				console.log(formData);

				$.ajax(
					{
					type: 'post',
					url: '/includes/partial/post/update_ticket.php',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data)
					{
						$('#ajax').html(data);
						console.log ("updated ticket");
					},
					error: function()
					{
						$('#ajax').html('error :' + error() );
						console.log ("error updating ticket");
					}
				});
			}
		});
		// End DOM Ready
	});
	</script>
</div>
<?php
	// log ticket views
	$STH = $DBH->Prepare("INSERT INTO call_views (sAMAccountName, callid) VALUES (:samaccountname , :callid)");
	$STH->bindParam(':samaccountname', $_SESSION['sAMAccountName'], PDO::PARAM_STR);
	$STH->bindParam(':callid', $row->callid, PDO::PARAM_STR);
	$STH->execute();


// close while loop
};
// close method post
};