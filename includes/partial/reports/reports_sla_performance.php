<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>SLA Performance (this month)</h3>
<div id="ajaxforms">
	<table>
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("
SELECT callid, title, assigned, calls.helpdesk, calls.urgency, close_eta_days, datediff(closed, opened) AS `total_days_to_close`
FROM calls
JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk 
WHERE service_level_agreement.urgency = calls.urgency AND status = 2 AND calls.helpdesk <=:helpdeskid AND Year(closed) = :year AND Month(closed) = :month
ORDER BY callid
			");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("
SELECT callid, title, assigned, calls.helpdesk, calls.urgency, close_eta_days, datediff(closed, opened) AS `total_days_to_close`
FROM calls
JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk 
WHERE service_level_agreement.urgency = calls.urgency AND status = 2 AND calls.helpdesk =:helpdeskid AND Year(closed) = :year AND Month(closed) = :month
ORDER BY callid
");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
		$STH->bindParam(':month', date("m"), PDO::PARAM_INT);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<tr><td colspan=4>0 tickets logged</td></tr>";};
		$passcounter = 0;
		$failcounter = 0;
		while($row = $STH->fetch()) {
		?>
		<?php if ($row->close_eta_days < $row->total_days_to_close) {
			$failcounter += 1;	
		?>
		<tr>
		<td>#<?=$row->callid;?></td>
		<td><?=$row->title;?></td>
		<td><?=engineer_friendlyname($row->assigned);?></td>
		<td>Overdue <?php echo($row->total_days_to_close - $row->close_eta_days);?> days</td>
		</tr>
		<?php
		} else {
				//passed SLA inc counter
				$passcounter += 1;
			};
		?>
	<? } 
		echo($failcounter . " tickets failed SLA");
		
	?>
	</tbody>
	</table>
	<p><?php echo($passcounter . " tickets passed SLA successfully"); ?></p>
	
</div>
