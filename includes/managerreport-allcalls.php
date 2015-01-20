<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>

<div id="ajaxforms">
	<table>
	<tbody>
	<?php
		//only my helpdesks
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk='.$_SESSION['engineerHelpdesk'];
		};
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id ".$whereenginners." ORDER BY callID DESC LIMIT 1000;");
		if (mysqli_num_rows($result) == 0) { echo "<p>All calls Closed</p>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td>

		<? if ($calls['status'] ==='2') {
			echo "<span class='closed'>Closed</span>";
			} else {
			echo date("d/m/y", strtotime($calls['opened']));
			};
		?></td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="allcallslist">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton"><?=substr(strip_tags($calls['details']), 0, 40);?>...</button>
			</form>
		</td>
		<td><?=strstr($calls['engineerName']," ", true);?></td>


		</tr>
	<? } ?>
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