<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="assigned-results">
<?php 
	
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT engineers.disabled, calls.helpdesk, engineers.idengineers, engineerName, Count(assigned) AS HowManyAssigned, sum(case when status !=2 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE engineers.helpdesk <= :helpdeskid GROUP BY assigned ORDER BY calls.helpdesk");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT engineers.disabled, calls.helpdesk, engineers.idengineers, engineerName, Count(assigned) AS HowManyAssigned, sum(case when status !=2 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE engineers.helpdesk = :helpdeskid GROUP BY assigned ORDER BY calls.helpdesk");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();	
	while($row = $STH->fetch()) { ?>
	<div class="<?=$row->helpdesk?>">
		<h3><?=$row->engineerName?><?php if ($row->disabled == '1') { echo("<span class='smalltxt'> ~ Disabled Engineer</span>"); }?><span style="float: right; font-size: 0.8rem;"><?=$row->OpenOnes?> assigned</span></h3>
		<table width="95%">
			<?php
			$STH2 = $DBH->Prepare("SELECT status, opened, callid, title, location.iconlocation, location.locationName FROM calls INNER JOIN location ON calls.location=location.id WHERE assigned = :assigned AND status IN (1,3,4)");
			$STH2->bindParam(":assigned", $row->idengineers, PDO::PARAM_INT);
			$STH2->setFetchMode(PDO::FETCH_OBJ);
			$STH2->execute();
			while($row2 = $STH2->fetch()) { ?>
			<tr>
				<td>#<?=$row2->callid;?></td>
				<td><img src="/public/images/<?=$row2->iconlocation;?>" alt="<?=$row2->locationName;?>" title="<?=$row2->locationName;?>" width="24px" height="auto"/></td>
				<td width="90px">
					<?php
					if ($row2->status == '2') { echo "<span class='closed'>CLOSED</span>"; }
					elseif ($row2->status == '3') { echo("<span class='hold'>ON HOLD</span>"); }
					elseif ($row2->status == '4') { echo("<span class='escalated'>ESCALATED</span>"); }
					elseif ($row2->status == '5') { echo("<span class='hold'>SENT AWAY</span>"); }
					else { echo "<span class='open'>" . date("d/m/y", strtotime($row2->opened)) . "</span>";} 
					?>
				</td>
				<td>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="viewticket">
						<input type="hidden" id="id" name="id" value="<?=$row2->callid;?>" />
						<input type="submit" name="submit" value="<?=substr(strip_tags(strtoupper($row2->title)), 0, 40);?>..." alt="View ticket" title="View ticket" class="calllistbutton"/>
					</form>
				</td>
			</tr>
			<? } ?>
		</table>
		<br />
	</div>	
<?php } ?>
</div>
<script type="text/javascript">
	$('.viewticket').submit(function(e) {
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