	<?php
	session_start();
	include_once 'includes/functions.php';
	// select calls for ID
	// run select query
	$sqlstr = "SELECT * FROM calls ";
	$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
	$sqlstr .= "INNER JOIN location ON calls.location=location.id ";
	$sqlstr .= "INNER JOIN categories ON calls.category=categories.id ";
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
	<?php if ($calls['urgency'] === '3') { echo "Urgent ";} ?><?=$calls['categoryName'];?> #<?=$_POST['id'];?><a href="viewcall.php?id=<?=$calls['callid'];?>" class="calllink">full details</a></h2>
	<p class="callheader">created by <a href="mailto:<?=$calls['email'];?>"><?=$calls['name'];?></a> (<?=$calls['tel'];?>)</p>	
	<p class="callheader">for <?=$calls['room'];?> - <?=$calls['locationName'];?></p>
	<p class="callheader">
					<?php
						if ($calls['status'] === '2') { echo "Call closed in ";} else { echo "Open for ";};
					
						$date1 = strtotime($calls['opened']);
						if ($calls['status'] ==='2') {$date2 = strtotime($calls['closed']);} else {$date2 = time();};
						$diff = $date2 - $date1;
						$d = ($diff/(60*60*24))%365;
						$h = ($diff/(60*60))%24;
						$m = ($diff/60)%60;
						echo $d." days, ".$h." hours, ".$m." minutes.";
					?></p>
	<?php if (!empty($calls['attachmentname'])) { ?><p><img src="/uploads/<?=$calls['attachmentname'];?>" width="100%" /></p><? }; ?>
	<p class="callbody"><?=$calls['details'];?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Call</button>
		<button name="update" value="update" type="submit">Update Call</button>
	</p>
	<p class="callfooter">Call Opened <?=date("d/m/y h:s", strtotime($calls['opened']));?><br />Last Update <?=date("d/m/y h:s", strtotime($calls['lastupdate']));?></p>
	</form>
	</div>
	<?php 
	// log user/engineer views
	$logsql = "INSERT INTO call_views (sAMAccountName, callid) VALUES ('" . $_SESSION['sAMAccountName'] . "','" . $calls['callid'] . "')";
	mysqli_query($db, $logsql);
	
	} ?>
