<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Scheduled Tickets</h2>
<p class="buttons"><button onclick="update_div('#ajax','form/add_scheduled_ticket.php')">Add New Scheduled Ticket</button></p>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Schedule</th>
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
		</tr>
<?php } ?>
	</tbody>
</table>


