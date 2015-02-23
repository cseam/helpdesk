<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Your Tickets</h3>
<div id="ajaxforms">
	<table id="yourcalls">
	<tbody>
	<?php
		$result = mysqli_query($db, "SELECT * FROM calls WHERE owner='". $_SESSION['sAMAccountName']  ."' ORDER BY callid DESC LIMIT 10");
			if (mysqli_num_rows($result) == 0) { echo "<p>No tickets logged. Please start by filling in the form.</p>"; };
			while($calls = mysqli_fetch_array($result))  { ?>
		<tr>
		<td><?php if ($calls['status'] == '2') { echo "<span class='closed'>CLOSED</span>"; } else { echo "<span class='open'>" . date("d/m/y", strtotime($calls['opened'])) . "</span>";} ?></td>
		<td class="view_td"><?php echo substr(strip_tags($calls['title']), 0, 90);?>...</td>
		<td>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="yourcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo $calls['callid'];?>" />
				<input type="image" name="submit" value="submit" src="/public/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View ticket" title="View ticket"/>
			</form>
		</td>
		</tr>
	<? }; ?>
	</tbody>
	</table>
</div>
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