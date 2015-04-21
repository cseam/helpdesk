<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE engineers.helpdesk <= :helpdeskid AND status !='2' ORDER BY opened LIMIT 1");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE engineers.helpdesk = :helpdeskid AND status !='2' ORDER BY opened LIMIT 1");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<p>0 Tickets logged</p>";};
	// display results to page
	while($row = $STH->fetch()) {
	?>
	<div id="calldetails">
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="updateForm">
	<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
	<input type="hidden" id="details" name="details" value="<?=$row->details;?>" />
	<h2>Ticket Details #<?=$row->callid;?></h2>
	<p class="callheader">Ticket #<?=$row->callid;?> <?php if ($row->urgency === '3') { echo("urgent ");} ?><?php echo($row->categoryName);?></p>
	<p class="callheader">Created by <a href="mailto:<?=$row->email;?>"><?=$row->name;?></a> (<?=$row->tel;?>)</p>
	<p class="callheader">For <?=$row->room;?> - <?=$row->locationName;?></p>
	<p class="callheader"><?php if ($row->assigned == NULL) { echo("Not assigned yet"); } else {?>Assigned to <?php echo(engineer_friendlyname($row->assigned)); }?></p>
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
	<p class="callbody"><?=nl2br($row->details);?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close</button>
		<button name="update" value="update" type="submit">Update</button>
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
<?php }