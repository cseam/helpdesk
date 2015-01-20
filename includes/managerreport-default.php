<h2>Open Calls</h2>
<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>

<div id="ajaxforms">
	<table>
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk=' .$_SESSION['engineerHelpdesk'];
		};
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id ".$whereenginners." AND status='1' ORDER BY callID;");
		if (mysqli_num_rows($result) == 0) { echo "<p>All calls Closed</p>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td width="45">
		<?php
		$datetime1 = new DateTime(date("Y-m-d", strtotime($calls['opened'])));
		$datetime2 = new DateTime(date("Y-m-d"));
		$interval = date_diff($datetime1, $datetime2);
		echo $interval->format('%a days');
		?>
		</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="viewpost">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton"><?=substr(strip_tags($calls['details']), 0, 65);?>...</button>
			</form>
		</td>
		<td>
			<?=strstr($calls['engineerName']," ", true);?>
		</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="forward">
			<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
			<input name="submit" value="" type="image" src="/images/ICONS-forward@2x.png" width="24" height="25" class="icon" alt="assign engineer" />
			</form>
		</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reassign">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<input name="submit" value="" type="image" src="/images/ICONS-assign@2x.png" width="24" height="25" class="icon" alt="assign engineer" />
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
	<script type="text/javascript">
     $('.viewpost').submit(function(e) {
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

	$('.reassign').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/reassign.php',
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

  	$('.forward').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/forward.php',
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
