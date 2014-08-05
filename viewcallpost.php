	<?php
	include 'includes/functions.php';
	// select calls for ID
	// run select query
	$sqlstr = "SELECT * FROM calls ";
	$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
	$sqlstr .= "WHERE callid =" . check_input($_POST['id']);
	$result = mysqli_query($db, $sqlstr);
	// display results to page
	while($calls = mysqli_fetch_array($result))  {
	?>
	<div id="calldetails">
	<form action="updatecall.php" method="post">
	<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
	<input type="hidden" id="details" name="details" value="<?=$calls['details'];?>" />
	<h2>
	<?php if ($calls['urgency'] === '3') { echo "Urgent ";} ?>Call Details #<a href="viewcall.php?id=<?=$calls['callid'];?>" class="calllink"><?=$_POST['id'];?></a></h2>
	<p class="callheader">created by <a href="mailto:<?=$calls['email'];?>"><?=$calls['name'];?></a> (<?=$calls['tel'];?>)</p>	
	<p class="callheader">for <?=$calls['room'];?> - <?=$calls['location'];?></p>
	<p class="callbody"><?=$calls['details'];?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Call</button>
		<button name="update" value="update" type="submit">Update Call</button>
	</p>
	<p class="callfooter">Call Opened <?=date("d/m/y h:s", strtotime($calls['opened']));?><br />Last Update <?=date("d/m/y h:s", strtotime($calls['lastupdate']));?></p>
	</form>
	</div>
	<?php } ?>
