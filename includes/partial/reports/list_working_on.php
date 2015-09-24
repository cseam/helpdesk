<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<?php 
	
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT engineers.disabled, calls.helpdesk, engineers.sAMAccountName, engineers.idengineers, engineerName, Count(assigned) AS HowManyAssigned, sum(case when status !=2 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE engineers.helpdesk <= :helpdeskid AND engineers.disabled != 1 GROUP BY assigned ORDER BY calls.helpdesk");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT engineers.disabled, calls.helpdesk, engineers.sAMAccountName, engineers.idengineers, engineerName, Count(assigned) AS HowManyAssigned, sum(case when status !=2 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE engineers.helpdesk = :helpdeskid AND engineers.disabled != 1 GROUP BY assigned ORDER BY calls.helpdesk");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();	
	while($row = $STH->fetch()) { ?>
		
		<h3><?php echo(engineer_friendlyname($row->idengineers)) ?></h3>
		<table>
			
			<?php
			$STH2 = $DBH->Prepare("SELECT call_views.callid, call_views.stamp, calls.title, calls.room, location.locationName, location.iconlocation FROM call_views
			JOIN calls ON call_views.callid = calls.callid
			JOIN location ON calls.location = location.id
			WHERE sAMAccountName = :sAMAccountName
			ORDER BY call_views.id DESC
			LIMIT 1");
			$STH2->bindParam(":sAMAccountName", $row->sAMAccountName, PDO::PARAM_STR);
			$STH2->setFetchMode(PDO::FETCH_OBJ);
			$STH2->execute();
				while($latest = $STH2->fetch()) { ?>
		<tr>
			<td>
				<img src="/public/images/<?=$latest->iconlocation;?>" alt="<?=$latest->locationName;?>-<?php echo($latest->room);?>" title="<?=$latest->locationName;?>-<?php echo($latest->room);?>" width="24px" height="auto" />
			</td>
			<td style="text-align: left;width: 90%;">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="yourcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo $latest->callid;?>" />
				<input type="submit" name="submit" value="#<?php echo($latest->callid); ?> &nbsp; <?php echo(substr(strip_tags($latest->title), 0, 150));?>" alt="View ticket" title="View ticket" class="calllistbutton"/>
				</form>
			</td>
			<td>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="yourcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo $latest->callid;?>" />
				<input type="image" name="submit" value="submit" src="/public/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View ticket" title="View ticket"/>
				</form>
			</td>
		</tr>
		<tr>
		<td colspan="6"><span class="smalltxt"><?php echo(engineer_friendlyname($row->idengineers));?> checked into ticket on <?php echo(date("d/m/Y H:i", strtotime($latest->stamp)));?></span>
		</td>
		</tr>
				<?php };
			?>
		</table><br/>
	<?php 
} 
?>

<script type="text/javascript">
	$('.yourcallslist').submit(function(e) {
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
			console.log('updated #ajax with view_ticket.php');
			e.preventDefault();
			return false;
	});
</script>
