<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>View Change Control</h2>
<table>
	<thead>
		<tr>
			<th>Who</th>
			<th>When</th>
			<th>Where</th>
			<th>Description</th>
			<th>Tags</th>
		</tr>
	</thead>
	<tbody>
<?php
	$STH = $DBH->Prepare("SELECT * FROM changecontrol INNER JOIN engineers ON changecontrol.engineersid=engineers.idengineers");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { ?>
<tr>
	<td><?= $row->engineerName ?></td>
	<td><?= date("d/m h:s", strtotime($row->stamp)) ?></td>
	<td><?= $row->server ?></td>
	<td><?= $row->changemade ?></td>
	<td><?= $row->tags ?></td>
</tr>
<?php } ?>
	</tbody>
</table>