<h2>Out of hours calls</h2>
<p class="buttons"><button onclick="update_div('#ajax','form/add_outofhours.php')">Log a new call</button></p>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Engineer</th>
			<th>Problem</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	$STH = $DBH->Prepare("SELECT * FROM out_of_hours ORDER BY id DESC");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=5>0 out of hours logged</td></tr>";};
		while($row = $STH->fetch()) { ?>
			<tr>
				<td><?php echo($row->id);?></td>
				<td><?php echo($row->dateofcall);?></td>
				<td><?php echo($row->name);?></td>
				<td><?php echo(substr($row->problem, 0, 40) . "...");?></td>
				<td>
					<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="outofhourslist">
						<input type="hidden" id="id" name="id" value="<?php echo($row->id);?>" />
						<input type="image" name="submit" value="submit" src="/public/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View call" title="View call"/>
					</form>
				</td>
			</tr>
<?php
}; ?>
	</tbody>
<script type="text/javascript">
	$('.outofhourslist').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/form/view_out_of_hours_call.php',
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
			console.log('updated #ajax with view_out_of_hours_call.php');
			e.preventDefault();
			return false;
	});
</script>