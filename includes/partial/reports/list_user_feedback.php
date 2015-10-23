<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Feedback Averages</h2>
<table>
	<tr>
		<th>Engineer<br/>Name</th>
		<th>Average<br/>Feedback</th>
		<th>Total<br/>Feedback</th>
	</tr>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT engineerName, AVG(feedback.satisfaction) as FeedbackAVG, COUNT(calls.callid) as FeedbackCOUNT FROM calls INNER JOIN feedback ON feedback.callid=calls.callid INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid WHERE engineers.helpdesk <= :helpdeskid GROUP BY calls.closeengineerid");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT engineerName, AVG(feedback.satisfaction) as FeedbackAVG, COUNT(calls.callid) as FeedbackCOUNT FROM calls INNER JOIN feedback ON feedback.callid=calls.callid INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid WHERE engineers.helpdesk = :helpdeskid GROUP BY calls.closeengineerid");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=3>0 feedback logged</td></tr>";};
	while($row = $STH->fetch()) { ?>
		<tr>
			<td><?=$row->engineerName;?></td>
			<td><? for ($i = 0; $i < round($row->FeedbackAVG); $i++) { echo("<img src='/public/images/ICONS-star.png' alt='star' height='24' width='auto' />"); }; ?></td>
			<td><?=$row->FeedbackCOUNT;?></td>
		</tr>
<?};?>
</table>
</br>
<h3>Poor Feedback Details</h3>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Engineer</th>
			<th>Customer</th>
			<th>Feedback</th>
		</tr>
	</thead>
	<tbody>
<?php 
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("
			SELECT calls.callid, engineers.engineerName, calls.owner, feedback.details, feedback.satisfaction FROM feedback 
			INNER JOIN calls ON feedback.callid=calls.callid 
			INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid
			WHERE engineers.helpdesk <= :helpdeskid
			AND satisfaction IN (1,2)
			");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("
			SELECT calls.callid, engineers.engineerName, calls.owner, feedback.details, feedback.satisfaction FROM feedback 
			INNER JOIN calls ON feedback.callid=calls.callid 
			INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid
			WHERE engineers.helpdesk = :helpdeskid
			AND satisfaction IN (1,2)
		");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=4>no poor feedback logged</td></tr>";};
	while($row = $STH->fetch()) { ?>
	<tr>
		<td>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="feedbacklist">
				<input type="hidden" id="id" name="id" value="<?php echo $row->callid;?>" />
				<input type="submit" name="submit" value="<?=$row->callid;?>" alt="View ticket" title="View ticket" class="calllistbutton"/>
			</form>
		</td>
		<td><?=$row->engineerName;?></td>
		<td><?=$row->owner;?></td>
		<td>
			<? for ($i = 0; $i < round($row->satisfaction); $i++) { echo("<img src='/public/images/svg/ICONS-star.svg' alt='star' height='24' width='auto' />"); }; ?>
		 <?=$row->details;?></td>
	</tr>
<?};?>
	
	</tbody>
</table>
<script type="text/javascript">
	$('.feedbacklist').submit(function(e) {
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