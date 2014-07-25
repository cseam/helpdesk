	<?php
	include 'includes/functions.php';
	// select calls for ID
	// run select query
	$sqlstr = "SELECT * FROM calls ";
	$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
	$sqlstr .= "WHERE callid =" . check_input($_POST['id']);
	$result = mysqli_query($db, $sqlstr);
	// display results to page
	while($calls = mysqli_fetch_array($result))  {
	?>
		<ul>
			<li>Call ID: #<?=$calls['callid'];?></li>
			<li>Primary Contact Name: <?=$calls['name'];?></li>
			<li>Primary Email: <?=$calls['email'];?></li>
			<li>Primary Telephone: <?=$calls['tel'];?></li>
			<li>Engineer Assigned: <?=$calls['assigned'];?> (<?=$calls['engineerName'];?> - <?=$calls['engineerEmail'];?>)</li>
			<li>Call Opened: <?=date("d/m/y h:s", strtotime($calls['opened']));?></li>
			<li>Call Last Update: <?=date("d/m/y h:s", strtotime($calls['lastupdate']));?></li>
			<li>Call Closed: <?=date("d/m/y h:s", strtotime($calls['closed']));?></li>
			<li>Status: <?=$calls['status'];?> (<?=$calls['statusCode'];?>)</li>
			<li>Urgency: <?=$calls['urgency'];?></li>
			<li>Location: <?=$calls['location'];?></li>
			<li>Room: <?=$calls['room'];?></li>
			<li>Category: <?=$calls['category'];?></li>
			<li>Call Details: <?=$calls['details'];?></li>
		</ul>
	<? } ?>
