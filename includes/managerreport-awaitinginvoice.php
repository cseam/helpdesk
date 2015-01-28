<?php session_start();?>
<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
	<table>
		<thead>
			<tr>
				<td>#</td>
				<td>Invoice Received</td>
				<td>Call Details</td>
			</tr>
		</thead>
		
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk=' .$_SESSION['engineerHelpdesk'];
		};
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id ".$whereenginners." ORDER BY callID;");
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td><input  type="checkbox" name="invoicetoggle"> <?=date("d/m/y");?></td>
		<td><?=substr(strip_tags($calls['details']), 0, 65);?>...</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>