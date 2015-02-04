<?php
// Global Vars & Settings
$codename = "Helpdesk";
$helpdeskloc = "http://helpdesk.cheltenhamladiescollege.co.uk";
$companyname = "CLC";
$companysuffix = "cheltenhamladiescollege.co.uk";
$ldapserver = "ldap://clcdc1.cheltenhamladiescollege.co.uk";
date_default_timezone_set('Europe/London');

// prompt authentication
function prompt_auth($data) {
	if (empty($_SESSION['sAMAccountName'])) {
		// User not logged in forward to login page
			//die("<script>location.href = '/auth/whoami.php?return=".$data."'</script>");
			die("<script>location.href = '/login/login.php?return=".$data."'</script>");
		};
}

//Database Setup
$db = mysqli_connect("localhost", "helpdesk", "helpdesk", "helpdesk");
// check db connection not sure if this should be done before each db call or once at function load is enough?
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
}

// Functions
function check_input($data)
{
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($db, $data);
    return $data;
}
function last_engineer($data)
{
	// check helpdesk call is for
	$helpdeskid = $data;
	//returns details for last engineer assigned a call.
	$data = "";
	// find and join last engineer assigned
	global $db;
	$sqlstr = "SELECT * FROM assign_engineers ";
	$sqlstr .= "INNER JOIN engineers ON assign_engineers.engineerid=engineers.idengineers ";
	$sqlstr .= "WHERE id=".$helpdeskid." ";
	$result = mysqli_query($db, $sqlstr);
	while($engdetails = mysqli_fetch_array($result)) {
	$data = $engdetails['engineerId'] . " - " . $engdetails['engineerName'] . " - " . $engdetails['engineerEmail'];
	}
	return $data;
}
function next_engineer($data)
{
	// Check helpdesk call is for
	$helpdeskid = $data;
	// Reset data and calculate next engineer
	$data = "";
	// find last engineer assigned
	global $db;
	$result = mysqli_query($db, "SELECT * FROM assign_engineers WHERE id=".$helpdeskid."");
	while($calls = mysqli_fetch_array($result))  {
			$lastengineerid = $calls['engineerId'];
		}
	// get last engineer full details from engineers table
	$result = mysqli_query($db, "SELECT * FROM engineers WHERE idengineers = " . $lastengineerid . "");
	while($engdetails = mysqli_fetch_array($result)) {
		$engineername = $engdetails['engineerName'];
		$engineeremail = $engdetails['engineerEmail'];
	}
	// get next engineer id from table
	$result = mysqli_query($db, "SELECT idengineers FROM engineers WHERE idengineers > " . $lastengineerid . " AND helpdesk=".$helpdeskid."  AND engineerLevel=1 ORDER BY idengineers LIMIT 1");
	// if end of list start from beginning again to create a a loop.
	if (mysqli_num_rows($result) == 0) {
		$result = mysqli_query($db, "SELECT idengineers FROM engineers WHERE helpdesk=".$helpdeskid." AND engineerLevel=1 LIMIT 1");
	}
	// output next engineers id to var
	while($next = mysqli_fetch_array($result)) {
		$nextid = $next['idengineers'];
	}
	return $nextid;
}
function engineer_friendlyname($data)
{
	global $db;
	$result = mysqli_query($db, "SELECT * FROM engineers WHERE idengineers='".$data."'");
	while($calls = mysqli_fetch_array($result)) {
		$friendly = $calls['engineerName'];
	}
	return $friendly;
}
function helpdesk_friendlyname($data)
{
	global $db;
	$query = mysqli_query($db, "SELECT * FROM helpdesks WHERE id=".$data.";");
	while($results = mysqli_fetch_array($query)) {
		$friendly = $results['helpdesk_name'];
	}
	return $friendly;
}
?>