<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Change Control</h2>
<p class="buttons"><button onclick="update_div('#ajax','reports/add_change_control.php')">Add Change Control</button><button onclick="update_div('#ajax','reports/view_tags.php')">Add Tags</button></p>
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
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=5>0 changes logged</td></tr>";};
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