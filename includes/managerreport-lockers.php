<?php session_start();?>
<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
	<table>
	<thead>
		<tr class="head">
			<th>#</th>
			<th>Ready</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Call Details</th>
			<th>Issue</th>
		</tr>
	</thead>
	<tbody>
	<?php
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE lockerid > 0 ORDER BY lockerid;");
		if (mysqli_num_rows($result) == 0) { echo "<p>Nothing in lockers</p>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td><?php echo($calls['lockerid']);?></td>
		<td><?php if ($calls['status'] === '2') {echo("Ready");};?></td>
		<td>
			<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="allcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo($calls['callid']);?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton" title="view call"><?php echo(substr(strip_tags($calls['details']), 0, 40));?>...</button>
			</form>
		</td>
		<td>{return to user button}</td>
		
		</tr>
	<?php }; ?>
	</tbody>
	</table>
</div>
	<script type="text/javascript">
    $('.allcallslist').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/viewcallpost.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/spinny.gif" alt="loading" class="loading"/>');
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