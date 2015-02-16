<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
	<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk=' .$_SESSION['engineerHelpdesk'];
	};

	// select calls for ID
	// run select query
	$sqloldeststr = "SELECT * FROM calls ";
	$sqloldeststr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqloldeststr .= "INNER JOIN status ON calls.status=status.id ";
	$sqloldeststr .= "INNER JOIN location ON calls.location=location.id ";
	$sqloldeststr .= $whereenginners . " AND status='1' ";
	$sqloldeststr .= "ORDER BY opened ";
	$sqloldeststr .= "LIMIT 1";
	$oldestresult = mysqli_query($db, $sqloldeststr);
	// display results to page
	while($call = mysqli_fetch_array($oldestresult))  {
	?>
	<div id="calldetails">
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="updateForm">
	<input type="hidden" id="id" name="id" value="<?=$call['callid'];?>" />
	<input type="hidden" id="details" name="details" value="<?=$call['details'];?>" />
	<h2><?=$call['title'];?></h2>
	<p class="callheader">Ticket #<?=$call['callid'];?></p>
	<p class="callheader">Created by <a href="mailto:<?=$call['email'];?>"><?=$call['name'];?></a> (<?=$call['tel'];?>)</p>
	<p class="callheader">For <?=$call['room'];?> - <?=$call['locationName'];?></p>
	<p class="callheader">Open for
					<?php
						$date1 = strtotime($calls['opened']);
						if ($calls['status'] ==='2') { $date2 = strtotime($calls['closed']); } else { $date2 = time(); };
						$diff = $date2 - $date1;
						$d = ($diff/(60*60*24))%365;
						$h = ($diff/(60*60))%24;
						$m = ($diff/60)%60;
						echo $d." days, ".$h." hours, ".$m." minutes.";
					?></p>
	<?php if (!empty($call['attachmentname'])) { ?><p><img src="/uploads/<?=$call['attachmentname'];?>" width="100%" /></p><? }; ?>
	<p class="callbody"><?=$call['details'];?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Ticket</button>
		<button name="update" value="update" type="submit">Update Ticket</button>
	</p>
	<p class="callfooter">Ticket Opened <?=date("d/m/y h:s", strtotime($call['opened']));?><br />Last Update <?=date("d/m/y h:s", strtotime($call['lastupdate']));?></p>
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
