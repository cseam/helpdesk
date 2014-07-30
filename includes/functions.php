<?php
// Global Vars & Settings
$codename = "Pantone Snail";
$companyname = "CLC";
$companysuffix = "cheltladiescollege.org";
date_default_timezone_set('Europe/London');


//Database Setup 
$db = mysqli_connect("localhost", "helpdesk", "helpdesk", "helpdesk");
// check db connection not sure if this should be done before each db call or once at function load is enough? 
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
}	

// Functions
function environ($data)
{
	// will be removed for production, but alows me to debug during development
    $data = "php, version " . phpversion();
    $data .= "<br/>" . substr($_SERVER['HTTP_USER_AGENT'], 0, 65);
    $data .= "<br/>Port " . $_SERVER['SERVER_PORT']; 
    $data .= "<br/>HTTP " . $_SERVER['REQUEST_METHOD']; 
    $data .= "<br/>" . date_default_timezone_get();
    $data .= "<br/>Session sAMAccountName: " . $_SESSION['sAMAccountName'];
    $data .= "<br/>Engineer Level:" . $_SESSION['engineerLevel'];
    return $data;
}

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
	//returns details for last engineer assigned a call.
	$data = "";
	// find and join last engineer assigned
	global $db;
	$sqlstr = "SELECT * FROM assign_engineers ";
	$sqlstr .= "INNER JOIN engineers ON assign_engineers.engineerid=engineers.idengineers";
	$result = mysqli_query($db, $sqlstr);
	while($engdetails = mysqli_fetch_array($result)) {
	$data = $engdetails['engineerId'] . " - " . $engdetails['engineerName'] . " - " . $engdetails['engineerEmail'];		
	}
	return $data;
}
function next_engineer($data)
{
	$data = "";
	// find last engineer assigned 
	global $db; 
	$result = mysqli_query($db, "SELECT * FROM assign_engineers");
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
	$result = mysqli_query($db, "SELECT idengineers FROM engineers WHERE idengineers > " . $lastengineerid . " ORDER BY idengineers LIMIT 1");
	// if end of list start from beginning again to create a a loop.
	if (mysqli_num_rows($result) == 0) {
		$result = mysqli_query($db, "SELECT idengineers FROM engineers LIMIT 1");
	} 
	// output next engineers id to var 
	while($next = mysqli_fetch_array($result)) {
		$nextid = $next['idengineers'];
	}
	
	// return data as required
	$data = $nextid;	
	return $data;
}
?>