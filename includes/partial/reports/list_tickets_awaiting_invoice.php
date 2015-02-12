<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Tickets Awaiting Invoice</h2>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['toggle'] == TRUE) { ?>
<?
	// update timestamp with changes
	$sqlstr = "UPDATE calls SET invoicedate='".date("c")."' WHERE callid='" . $_POST['id'] . "';";
	$result = mysqli_query($db, $sqlstr);
 } ?>
<div id="ajaxforms">
	<table>
		<thead>
			<tr>
				<td>#</td>
				<td>Received</td>
				<td>Date</td>
				<td>Ticket Details</td>
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
		<td>
			<div class="switch" style="float:left;">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="toggleform" >
				<input type="hidden" id="toggle" name="toggle" value="TRUE" />
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<input id="cmn-toggle-<?=$calls['callid']?>" name="cmn-toggle-<?=$calls['callid']?>" class="cmn-toggle cmn-toggle-round" type="checkbox" <? if ($calls['invoicedate'] !== null) { ?>checked="true" <?}?>>
				<label for="cmn-toggle-<?=$calls['callid']?>"></label>
			</form>
		</div>
		<td><? if ($calls['invoicedate'] !== null) { echo date("d/m/y", strtotime($calls['invoicedate'])); };?></td>
		<td><?=substr(strip_tags($calls['title']), 0, 65);?>...</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
<script type="text/javascript">
    $('.toggleform').change(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/reports/list_tickets_awaiting_invoice.php',
				data: $(this).serialize(),
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