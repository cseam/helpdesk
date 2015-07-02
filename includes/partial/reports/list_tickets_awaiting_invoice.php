<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Tickets Awaiting Invoice</h2>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['toggle'] == TRUE) { ?>
<?
	// update timestamp with changes
	$STH = $DBH->Prepare("UPDATE calls SET invoicedate = :invoicedate WHERE callid = :callid");
	$STH->bindParam(":invoicedate", date("c"), PDO::PARAM_STR);
	$STH->bindParam(":callid", $_POST['id'], PDO::PARAM_STR);
	$STH->execute();
};?>
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
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id WHERE engineers.helpdesk <= :helpdeskid AND status='5' ORDER BY callID");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id WHERE engineers.helpdesk = :helpdeskid AND status='5' ORDER BY callID");
			$hdid = $_SESSION['engineerHelpdesk'];
		};
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		while($row = $STH->fetch()) {
	?>
		<tr>
		<td>#<?=$row->callid;?></td>
		<td>
			<div class="switch" style="float:left;">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="toggleform" >
				<input type="hidden" id="toggle" name="toggle" value="TRUE" />
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<input id="cmn-toggle-<?=$row->callid?>" name="cmn-toggle-<?=$row->callid?>" class="cmn-toggle cmn-toggle-round" type="checkbox" <? if ($row->invoicedate !== null) { ?>checked="true" <?}?>>
				<label for="cmn-toggle-<?=$row->callid?>"></label>
			</form>
		</div>
		<td><? if ($row->invoicedate !== null) { echo date("d/m/y", strtotime($row->invoicedate)); };?></td>
		<td><?=substr(strip_tags($row->title), 0, 65);?>...</td>
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