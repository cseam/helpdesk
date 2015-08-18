<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
<h3>Performance Objectives</h3>
<p class="buttons"><button onclick="update_div('#ajax','form/add_objective.php')">Add Performance Objective</button></p>
<p class="note">Showing all open performance objectives grouped by engineer</p>
	<table>
	<tbody>
	<?php
		
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT * FROM performance_review_objectives 
		INNER JOIN engineers ON performance_review_objectives.engineerid = engineers.idengineers
		WHERE engineers.helpdesk<=:helpdeskid AND status !='2' ORDER BY engineers.idengineers");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT * FROM performance_review_objectives 
		INNER JOIN engineers ON performance_review_objectives.engineerid = engineers.idengineers
		WHERE engineers.helpdesk=:helpdeskid AND status !='2'");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
				
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_INT);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<p>0 performance objectives set</p>";};
		while($row = $STH->fetch()) {
		?>
			<tr>
				<td>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
						<input type="hidden" id="id" name="id" value="<?=$row->id;?>" />
						<input type="submit" name="submit" value="<?=substr(strip_tags($row->title), 0, 50);?>..." alt="View objective" title="View objective" class="calllistbutton"/>
					</form>
				
				
				</td>
				<td><?php echo(engineer_friendlyname($row->engineerid)); ?></td>
				<td><?php echo($row->progress); ?>%</td>
				<td><?php echo(date("M Y", strtotime($row->datedue))); ?></td>
				<td>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
						<input type="hidden" id="id" name="id" value="<?=$row->id;?>" />
						<input type="image" name="submit" value="submit" src="/public/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View objective" title="View objective" />
					</form>
				</td>
			</tr>
		<? }; ?>
	</tbody>
	</table>
</div>

<script type="text/javascript">
	$('.assignedtoyou').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/form/view_objective.php',
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