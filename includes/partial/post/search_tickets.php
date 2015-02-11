<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk=' .$_SESSION['engineerHelpdesk'];
	};



	$sqlstr = "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id " . $whereenginners;
	$sqlstr .= " AND details LIKE '%" . check_input($_POST['term']) . "%';";
	$result = mysqli_query($db, $sqlstr);
?>
<table>
	<tbody>
<?php
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
		<td><?=strstr($calls['engineerName']," ", true);?></td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="searchresultsview" >
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<div style="margin-top:10px;float: left;"><?=substr(strip_tags($calls['details']), 0, 40);?>...</div>
				<input type="image" name="submit" value="submit" src="/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View ticket" />
			</form>
		</td>
		</tr>
<?  }; ?>
	</tbody>
</table>
<?php
		if (mysqli_num_rows($result) == 0) {
		echo "<p>&mdash; 0 results returned.</p>";
	} else {
		echo "<p>&mdash; " . mysqli_num_rows($result) . " result returned.</p>";
	} ;
?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
     $('.searchresultsview').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/view_ticket.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
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