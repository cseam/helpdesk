<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// check authentication
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };


	if ($_SERVER['REQUEST_METHOD']== "POST") {
		// get ticket for post id
		$sqlstr = "SELECT * FROM calls ";
		$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
		$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
		$sqlstr .= "INNER JOIN location ON calls.location=location.id ";
		$sqlstr .= "INNER JOIN categories ON calls.category=categories.id ";
		$sqlstr .= "WHERE callid =" . check_input($_POST['id']);
		$result = mysqli_query($db, $sqlstr);
		// update view
		while($calls = mysqli_fetch_array($result))  {
?>
<div id="calldetails">
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="updateForm">
		<input type="hidden" id="id" name="id" value="<?php echo($calls['callid']);?>" />
		<input type="hidden" id="button_value" name="button_value" value="" />
		<input type="hidden" id="details" name="details" value="<?php echo($calls['details']);?>" />
		<h2><?php echo($calls['title']);?></h2>
		<p class="callheader">#<?php echo($_POST['id']);?> <?php if ($calls['urgency'] === '3') { echo("Urgent ");} ?><?php echo($calls['categoryName']);?></p>
		<p class="callheader">Created by <a href="mailto:<?php echo($calls['email']);?>"><?php echo($calls['name']);?></a></p>
		<p class="callheader">Contact Number:<?php echo($calls['tel']);?></p>
		<p class="callheader"><?php echo($calls['room']);?> - <?php echo($calls['locationName']);?></p>
		<p class="callheader">Assigned to <?php echo(engineer_friendlyname($calls['assigned']));?></p>
		<p class="callheader">
		<?php
		if ($calls['status'] === '2') { echo("Call closed in ");} else { echo("Open for ");};
			$date1 = strtotime($calls['opened']);
			if ($calls['status'] ==='2') {$date2 = strtotime($calls['closed']);} else {$date2 = time();};
			$diff = $date2 - $date1;
			$d = ($diff/(60*60*24))%365;
			$h = ($diff/(60*60))%24;
			$m = ($diff/60)%60;
			echo( $d." days, ".$h." hours, ".$m." minutes.");
		?>
		</p>
		<?php if ($calls['lockerid'] != null) { ?><p class="callheader">Locker #<?php echo($calls['lockerid']);?></p><?php }; ?>
		<?php
		$additional_field_sql = "SELECT * FROM call_additional_results WHERE callid = ".$calls['callid'].";";
		$additional_field_result = mysqli_query($db, $additional_field_sql);
			while ($items = mysqli_fetch_array($additional_field_result)) { ?>
		<p class="callheader"><?php echo($items['label']);?> - <?php echo($items['value']);?></p>
		<?php }; ?>
		<p class="callbody"><?php echo($calls['details']);?></p>
	<fieldset>
		<legend>Update Ticket</legend>
		<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
		<p><label for="attachment">Picture or Screenshot</label><input type="file" name="attachment" accept="image/*" style="background-color: transparent;" id="attachment"></p>
		<?php if ($_SESSION['engineerId'] !== null) {?>
		<?php
		// filter for engineers helpdesks
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE helpdesk_id <= 3';
		} else {
			$whereenginners = 'WHERE helpdesk_id='.$_SESSION['engineerHelpdesk']."'";
		};
		?>
	</fieldset>
	<fieldset>
		<legend>Engineer Controls</legend>
			<span class="engineercontrols">
				<label for="callreason">Reason for issue</label>
				<select id="callreason" name="callreason">
					<option value="" SELECTED>Please Select</option>
					<?php
						$callreasons = mysqli_query($db, "SELECT * FROM callreasons ".$whereenginners." ORDER BY reason_name;");
						while($option = mysqli_fetch_array($callreasons)) { ?>
						<option value="<?php echo($option['id']);?>"><?php echo($option['reason_name']);?></option>
					<?php }; ?>
				</select>
				<label for="quickresponse">Quick Response</label>
				<select id="quickresponse" name="quickresponse">
					<option value="" SELECTED>Please Select</option>
					<?php
						$quickresponses = mysqli_query($db, "SELECT * FROM quick_responses ".$whereenginners." ORDER BY quick_response;");
						while($option = mysqli_fetch_array($quickresponses)) { ?>
						<option value="<?php echo($option['quick_response']);?>"><?php echo($option['quick_response']);?></option>
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
			<?php if ($calls['status'] === '1') {?>
			<button name="close" value="close" type="submit" onclick="this.form.button_value.value = this.value;">Close Ticket</button>
			<?php };?>
			<button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">Update Ticket</button>
			</p>
			<p class="callfooter">Call Opened <?php echo(date("d/m/y h:s", strtotime($calls['opened'])));?><br />
			Last Update <?php echo(date("d/m/y h:s", strtotime($calls['lastupdate'])));?></p>
	</fieldset>
	</form>
	<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state

		// Client side form validation
		$("#updateForm").validate({
			rules: {
				updatedetails: {
					required: true,
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
// log user/engineer views
$logsql = "INSERT INTO call_views (sAMAccountName, callid) VALUES ('" . $_SESSION['sAMAccountName'] . "','" . $calls['callid'] . "')";
mysqli_query($db, $logsql);
};


};
?>