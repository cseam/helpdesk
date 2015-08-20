<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
<h3>Failed Tickets (this month)</h3>
	<table>
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ticket</th>
			<th>Engineer</th>
			<th>Overdue</th>
		</tr>
	</thead>		
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("
SELECT callid, title, assigned, calls.helpdesk, calls.urgency, close_eta_days, datediff(closed, opened) AS `total_days_to_close`
FROM calls
JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk 
WHERE service_level_agreement.urgency = calls.urgency AND calls.helpdesk <=:helpdeskid AND Year(closed) = :year AND Month(closed) = :month
ORDER BY assigned
			");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("
SELECT callid, title, assigned, calls.helpdesk, calls.urgency, close_eta_days, datediff(closed, opened) AS `total_days_to_close`
FROM calls
JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk 
WHERE service_level_agreement.urgency = calls.urgency AND calls.helpdesk =:helpdeskid AND Year(closed) = :year AND Month(closed) = :month
ORDER BY assigned
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
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
			<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
			<input type="submit" name="submit" value="<?=substr(strip_tags($row->title), 0, 40);?>..." alt="View ticket" title="View ticket" class="calllistbutton"/>
			</form>
		</td>
		<td><?php
			$engineername = engineer_friendlyname($row->assigned);
			$fullname = explode(' ', $engineername);
			$first_name = $fullname[0];
			echo($first_name);
			?></td>
		<td><?php echo($row->total_days_to_close - $row->close_eta_days);?> days</td>
		</tr>
		<?php
		} else {
				//passed SLA inc counter
				$passcounter += 1;
			};
		?>
	<? } ?>
	</tbody>
	</table>
	<p class="note"><?php echo($passcounter . " tickets passed"); ?> / <?php echo($failcounter . " tickets failed"); ?> / <?php 
		$totalcounter = $passcounter + $failcounter;
		echo("fail rate " . round(($failcounter / $totalcounter) * 100) . "% this month"); ?></p>
	<h3>Currently Open & Failing</h3>
	<table>
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ticket</th>
			<th>Engineer</th>
			<th>Overdue</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("
SELECT callid, title, assigned, calls.helpdesk, calls.urgency, close_eta_days, datediff(now(), opened) AS `total_days_to_close`
FROM calls
JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk 
WHERE service_level_agreement.urgency = calls.urgency AND status=1 AND calls.helpdesk <=:helpdeskid
ORDER BY assigned
			");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("
SELECT callid, title, assigned, calls.helpdesk, calls.urgency, close_eta_days, datediff(now(), opened) AS `total_days_to_close`
FROM calls
JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk 
WHERE service_level_agreement.urgency = calls.urgency AND status=1 AND calls.helpdesk =:helpdeskid 
ORDER BY assigned
");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<tr><td colspan=4>0 tickets logged</td></tr>";};
		while($row = $STH->fetch()) {
		?>
		<?php if ($row->close_eta_days < $row->total_days_to_close) {?>
		<tr>
		<td>#<?=$row->callid;?></td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
			<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
			<input type="submit" name="submit" value="<?=substr(strip_tags($row->title), 0, 40);?>..." alt="View ticket" title="View ticket" class="calllistbutton"/>
			</form>
		</td>
		<td>
		<?php
			$engineername = engineer_friendlyname($row->assigned);
			$fullname = explode(' ', $engineername);
			$first_name = $fullname[0];
			echo($first_name);
			?>
		</td>
		<td><?php echo($row->total_days_to_close - $row->close_eta_days);?> days</td>
		</tr>
		<?php
			};
		}
		?>
		</tbody>
		</table>
		
		<p class="note">fail rate including open calls <?php echo(round((($failcounter + $STH->rowCount()) / $totalcounter) * 100)); ?> %</p>
			
</div>
<script type="text/javascript">
	$('.assignedtoyou').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/form/view_ticket.php',
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