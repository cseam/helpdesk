<?php
function callsinlastday($data) {
	// returns calls opened in interval of 1 day
	global $db;
	$sql = "SELECT COUNT(callID) AS count FROM calls WHERE opened >= DATE_SUB(CURDATE(),INTERVAL 1 DAY);";
	$result = mysqli_query($db, $sql);
	while($loop = mysqli_fetch_array($result)) {
		$data = $loop['count'];		
	}
	return $data;
}
function callsclosedinlastday($data) {
	// returns calls closed in interval of 1 day
	global $db;
	$sql = "SELECT COUNT(callID) AS count FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY);";
	$result = mysqli_query($db, $sql);
	while($loop = mysqli_fetch_array($result)) {
		$data = $loop['count'];		
	}
	return $data;
}
function topengineer($data) {
	// returns engineer who has closed most calls in 7 day interval unless passed count then returns number
	$what = $data;
	global $db;
	$sql = "SELECT closeengineerid, engineerName, Count(closeengineerid) AS HowMany FROM calls INNER JOIN engineers ON calls.closeengineerid=engineers.idengineers WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) GROUP BY closeengineerid order by HowMany;";
	$result = mysqli_query($db, $sql);
	while($loop = mysqli_fetch_array($result)) {
		if ((string)$what === "count") {
			$data = $loop['HowMany'];
		} else {
			$data = $loop['engineerName'];
		}
	}
	return $data;
}
function bottomengineer($data) {
	// returns engineer who has closed least calls in 7 day interval unless passed count then returns number
	$what = $data;
	global $db;
	$sql = "SELECT closeengineerid, engineerName, Count(closeengineerid) AS HowMany FROM calls INNER JOIN engineers ON calls.closeengineerid=engineers.idengineers WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) GROUP BY closeengineerid order by HowMany DESC;";
	$result = mysqli_query($db, $sql);
	while($loop = mysqli_fetch_array($result)) {
		if ((string)$what === "count") {
			$data = $loop['HowMany'];
		} else {
			$data = $loop['engineerName'];
		}
	}
	return $data;	
}

?>