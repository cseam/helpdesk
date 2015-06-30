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
			<th>Who / When / Where / What</th>
			<th>Change</th>
		</tr>
	</thead>
	<tbody>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT * FROM changecontrol INNER JOIN engineers ON changecontrol.engineersid=engineers.idengineers WHERE changecontrol.helpdesk <= :helpdeskid ORDER BY id DESC");
		$hdid = 3;

	} else {
		$STH = $DBH->Prepare("SELECT * FROM changecontrol INNER JOIN engineers ON changecontrol.engineersid=engineers.idengineers WHERE changecontrol.helpdesk = :helpdeskid ORDER BY id DESC");
		$hdid = $_SESSION['engineerHelpdesk'];

	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=5>0 changes logged</td></tr>";};
	while($row = $STH->fetch()) { ?>
<tr>
	<td>
		<ul>
			<li><?= $row->engineerName ?></li>
			<li><?= date("d/m h:s", strtotime($row->stamp)) ?></li>
			<li><?= $row->server ?></li>
			<li>Tags: <?= $row->tags ?></li>
		</ul>
	</td>
	<td><?= $row->changemade ?></td>
</tr>
<?php } ?>
	</tbody>
</table>