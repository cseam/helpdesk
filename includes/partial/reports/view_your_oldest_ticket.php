<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// select calls for ID
	$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE status='1' AND assigned = :assigned ORDER BY opened LIMIT 1");
	$STH->bindParam(":assigned", $_SESSION['engineerId'], PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo("<h3>0 assigned calls</h3>"); };
	while($row = $STH->fetch()) {
	?>
	<div id="calldetails">
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="updateForm">
	<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
	<input type="hidden" id="details" name="details" value="<?=$row->details;?>" />
	<h2>Oldest Ticket</h2>
	<h3><?=$row->title;?></h3>
	<p class="callheader">Created by <a href="mailto:<?=$row->email;?>"><?=$row->name;?></a> (<?=$row->tel;?>)</p>
	<p class="callheader">For <?=$row->room;?> - <?=$row->locationName;?></p>
	<p class="callheader">Open for
					<?php
						$date1 = strtotime($row->opened);
						if ($row->status ==='2') { $date2 = strtotime($row->closed); } else { $date2 = time(); };
						$diff = $date2 - $date1;
						$d = ($diff/(60*60*24))%365;
						$h = ($diff/(60*60))%24;
						$m = ($diff/60)%60;
						echo $d." days, ".$h." hours, ".$m." minutes.";
					?></p>
	<?php if (!empty($row->attachmentname)) { ?><p><img src="/uploads/<?=$row->attachmentname;?>" width="100%" /></p><? }; ?>
	<?php
		// populate additional fields
		$STHloop = $DBH->Prepare("SELECT * FROM call_additional_results WHERE callid = :callid");
		$STHloop->bindParam(':callid', $row->callid, PDO::PARAM_STR);
		$STHloop->setFetchMode(PDO::FETCH_OBJ);
		$STHloop->execute();
		while($row2 = $STHloop->fetch()) { ?>
			<p class="callheader"><?php echo($row2->label);?> - <?php echo($row2->value);?></p>
	<?php }; ?>
	<p class="callbody"><?=$row->details;?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p><label for="attachment" style="width: 190px">Picture or Screenshot</label><input type="file" name="attachment" accept="image/*" style="background-color: transparent;" id="attachment"></p>


	<?php if ($_SESSION['engineerId'] !== null) {?>
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
	<?php } ?>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Ticket</button>
		<button name="update" value="update" type="submit">Update Ticket</button>
	</p>
	<p class="callfooter">Ticket Opened <?=date("d/m/y h:s", strtotime($row->opened));?><br />Last Update <?=date("d/m/y h:s", strtotime($row->lastupdate));?></p>
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
				$.ajax(
					{
					type: 'post',
					url: '/includes/partial/post/update_ticket.php',
					data: $("#updateForm").serialize(),
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
	<?php } ?>