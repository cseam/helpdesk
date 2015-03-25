<?php
// prompt authentication
function prompt_auth($data) {
	if (empty($_SESSION['sAMAccountName'])) {
		// User not logged in forward to login page
			die("<script>location.href = '/login/login.php?return=".$data."'</script>");
		};
}

//Database Setup

// using SQLi (will be replaced by PDO but until then needed to continue working)
$db = mysqli_connect(DB_LOC, DB_SCHEMA, DB_USER, DB_PASSWORD);
// check db connection not sure if this should be done before each db call or once at function load is enough?
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
}
// using PDO
try {
	# PDO_MYSQL
	$DBH = new PDO("mysql:host=".DB_LOC.";dbname=".DB_SCHEMA, DB_USER, DB_PASSWORD);
	# Display development errors
	if (DEVELOPMENT_ENVIRONMENT === true) {
		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
}
catch(PDOException $e) {
	echo($e->getMessage());
}

// Classes
class ticket {
	public $name;
	public $email;
	public $tel;
	public $details;
	public $assigned;
	public $opened;
	public $lastupdate;
	public $status;
	public $closed;
	public $closeengineerid;
	public $urgency;
	public $location;
	public $room;
	public $category;
	public $owner;
	public $helpdesk;
	public $invoicedate;
	public $callreason;
	public $title;
	public $lockerid;

	function __construct($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t) {
		$this->name = $a;
		$this->email = $b;
		$this->tel = $c;
		$this->details = $d;
		$this->assigned = $e;
		$this->opened = $f;
		$this->lastupdate = $g;
		$this->status = $h;
		$this->closed = $i;
		$this->closeengineerid = $j;
		$this->urgency = $k;
		$this->location = $l;
		$this->room = $m;
		$this->category = $n;
		$this->owner = $o;
		$this->helpdesk = $p;
		$this->invoicedate = $q;
		$this->callreason = $r;
		$this->title = $s;
		$this->lockerid = $t;
	}
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
function random_locker()
{
	global $db;
		$min=1;
		$max=36;
		$lockerid = rand($min,$max);
	return $lockerid;
}
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