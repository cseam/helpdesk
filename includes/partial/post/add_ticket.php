<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// process form
	if ($_SERVER['REQUEST_METHOD']== "POST") {	?>
	<h2>Thank you</h2>
	<p>Your ticket has been added and has been assigned to <?php if ($_POST['cmn-toggle-selfassign'] !== null) { echo engineer_friendlyname(check_input($_POST['cmn-toggle-selfassign'])); } else { echo engineer_friendlyname(next_engineer(check_input($_POST['helpdesk']))); }; ?>, the engineer will be in touch shortly if they require additional information, any correspondence will be emailed to the contact address you entered in the form.</p>
	<p>Please check your email for further details.</p>

<?php
	// Upload attachments (need to check mime type also at some point)
		if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
			$name_of_uploaded_file = substr(md5(microtime()),rand(0,26),10);
			$folder = ROOT . UPLOAD_LOC . $name_of_uploaded_file;
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			move_uploaded_file($tmp_path, $folder);
			$upload_img_code = "<img src=" . UPLOAD_LOC . $name_of_uploaded_file . " width=100% />";
		}

	// Calculate Urgency
		$urgencystr = round( (check_input($_POST['callurgency']) + check_input($_POST['callseverity'])) / 2 );

	// Create Query (need to conver to PDO with prepare this is crap)
		$sqlstr = "INSERT INTO calls ";
		$sqlstr .= "(name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, title, lockerid) ";
		$sqlstr .= "VALUES (";
		$sqlstr .= " '" . check_input($_POST['name']) . "',";
		$sqlstr .= " '" . check_input($_POST['email']) . "',";
		$sqlstr .= " '" . check_input($_POST['tel']) . "',";
		$sqlstr .= " '<div class=original>" . $upload_img_code . check_input($_POST['details']) . "</div>',";
			if ($_POST['cmn-toggle-selfassign'] !== null) {
				$sqlstr .= " '" . check_input($_POST['cmn-toggle-selfassign']) . "',";
			} else {
				$sqlstr .= " '" . next_engineer(check_input($_POST['helpdesk'])) . "',";
			};
		$sqlstr .= " '" . date("c") . "',";
		$sqlstr .= " '" . date("c") . "',";
			if ($_POST['cmn-toggle-retro'] !== null) {
				$sqlstr .= " '2',";
				$sqlstr .= " '". date("c") ."',";
				$sqlstr .= " '". check_input($_POST['cmn-toggle-selfassign']) ."',";
			} else {
				$sqlstr .= " '1',";
				$sqlstr .= " null,";
				$sqlstr .= " null,";
			};
		$sqlstr .= " '" . $urgencystr . "',";
		$sqlstr .= " '" . check_input($_POST['location']) . "',";
		$sqlstr .= " '" . check_input($_POST['room']) . "',";
		$sqlstr .= " '" . check_input($_POST['category']) . "',";
		$sqlstr .= " '" . $_SESSION['sAMAccountName'] . "',";
		$sqlstr .= " '" . check_input($_POST['helpdesk']) . "',";
		$sqlstr .= " '" . check_input($_POST['title']) . "',";
			if ($_POST['category'] != '11' ) {
				$sqlstr .= " " . "null" . " ";
			} else {
				$lockerid = random_locker();
				$sqlstr .= " '". $lockerid ."' ";
				// Print locker number to screen
				echo("<fieldset><legend>Engineer Note</legend><p class='lockernotice'>store laptop in locker #". $lockerid ."</p></fieldset>");
			};
		$sqlstr .= ")";

	// Run Query
	mysqli_query($db, $sqlstr);

	// Create Addition Fields Query
	// Get call id
	$helpdeskcallid = mysqli_insert_id($db);
	// find out how many fields to insert
	$additionalfieldstoinsert = mysqli_query($db, "SELECT * FROM call_additional_fields WHERE typeid =".$_POST['category']." ;");
	//for each field insert its value
	while($loop = mysqli_fetch_array($additionalfieldstoinsert))  {
		$insertname = "label" . $loop['id'];
		$sqladditional = "INSERT INTO call_additional_results (callid, label, value) VALUES ";
		$sqladditional .= "('".$helpdeskcallid."','".$loop['label']."','".$_POST[$insertname]."')";
		mysqli_query($db, $sqladditional);
	};

	// Update engineers assignment (id hard coded for dev needs to be specific to department if they want round robin)
	mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer(check_input($_POST['helpdesk'])) ."' WHERE id='".$_POST['helpdesk']."'");

	// Close Connection
	mysqli_close($db);
}
?>
<script type="text/javascript">
	update_div('#calllist','/reports/list_your_tickets.php');
</script>