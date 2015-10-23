<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Scheduled Tickets</h3>
<p class="buttons"><button onclick="update_div('#ajax','form/add_scheduled_ticket.php')">Add New Scheduled Ticket</button></p>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Schedule</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Remove</th>
		</tr>
	</thead>
	<tbody>
<?php
	
	if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT * FROM scheduled_calls WHERE helpdesk <= :helpdesk");
			$hdid = 3;
	} else {
			$STH = $DBH->Prepare("SELECT * FROM scheduled_calls WHERE helpdesk = :helpdesk");
			$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdesk", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=3>0 scheduled tickets</td></tr>";};
	while($row = $STH->fetch()) { ?>
		<tr>
			<td><?= $row->callid ?></td>
			<td><?= $row->title ?></td>
			<td><?= $row->frequencytype ?></td>
			<td>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="removeschedule">
					<input type="hidden" id="id" name="id" value="<?= $row->callid;?>" />
					<input type="submit" name="submit" value="Remove" alt="Remove" title="Remove Change" class="calllistbutton"/>
				</form>
			</td>
		</tr>
<?php } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('.removeschedule').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/remove_scheduledticket.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/public/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
				},
				success: function(data)
				{
				$('#ajax').html(data);
				},
				error: function()
				{
				$('#ajax').html('error loading data, please refresh.');
				}
			});
		e.preventDefault();
		return false;
	});
</script>
