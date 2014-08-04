	<?php
	// select calls for ID
	// run select query
	$sqloldeststr = "SELECT * FROM calls ";
	$sqloldeststr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqloldeststr .= "INNER JOIN status ON calls.status=status.id ";
	$sqloldeststr .= "WHERE status='1' AND assigned='". $_SESSION['engineerId'] . "' ";
	$sqloldeststr .= "ORDER BY opened ";
	$sqloldeststr .= "LIMIT 1";
	$oldestresult = mysqli_query($db, $sqloldeststr);
	// display results to page
	while($call = mysqli_fetch_array($oldestresult))  {
	?>
	<div id="calldetails">
	<form action="updatecall.php" method="post">
	<input type="hidden" id="id" name="id" value="<?=$call['callid'];?>" />
	<input type="hidden" id="details" name="details" value="<?=$call['details'];?>" />
	<h2>Oldest Call Details #<?=$call['callid'];?></h2>
	<p class="callheader"><a href="mailto:<?=$call['email'];?>"><?=$call['name'];?></a> (<?=$call['tel'];?>)</p>	
	<p class="callheader"><?=$call['room'];?> - <?=$call['location'];?></p>
	<p class="callbody"><?=$call['details'];?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Call</button>
		<button name="update" value="update" type="submit">Update Call</button>
	</p>
	<p class="callfooter">Opened <?=date("d/m/y h:s", strtotime($call['opened']));?><br />Last Update <?=date("d/m/y h:s", strtotime($call['lastupdate']));?></p>
	</form>
	</div>
	<?php } ?>
