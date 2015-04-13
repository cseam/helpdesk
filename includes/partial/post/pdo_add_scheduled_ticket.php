<?php
// start sessions
session_start();
// load functions
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
// Process form POST

if ($_SERVER['REQUEST_METHOD']== "POST") {
	// Upload attachments
	if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
			// rename file to random name to avoid file name clash
			$name_of_uploaded_file = substr(md5(microtime()),rand(0,26),10);
			// define uploads folder from config
			$folder = ROOT . UPLOAD_LOC . $name_of_uploaded_file;
			// define temp upload location
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			// move file from temp location to uploads folder
			move_uploaded_file($tmp_path, $folder);
			// create html img tag for ticket detail
			$upload_img_code = "<img src=" . UPLOAD_LOC . $name_of_uploaded_file . " alt=upload width=100% />";
	}

	// Calculate Urgency
	$urgency = round((check_input($_POST['callurgency']) + check_input($_POST['callseverity'])) / 2 );

	// Generate locker number if needed
	if ($_POST['category'] != '11' ) {
		$lockerid = null;
		$lockerflash = '';
	} else {
		// Generate Lockerid
		$lockerid = random_locker();
		$lockerflash = "<fieldset><legend>Engineer Note</legend><p class='lockernotice'>store laptop in locker #". $lockerid ."</p></fieldset>";
	};

	// Generate ticket details including any images uploaded
	$ticketdetails = "<div class=original>" . $upload_img_code . $_POST['details'] . "</div>";

	if ($_POST['assigned'] == 'DONT') {
		$assignedengineer = NULL;
	} elseif ($_POST['assigned'] == 'AUTO') {
		$assignedengineer = next_engineer($_POST['helpdesk']);
	} else {
		$assignedengineer = $_POST['assigned'];
	};

	$status = '1';
	$closed = null;
	$closeengineerid = null;
	$invoicedate = null;
	$callreason = null;


	// Prepare ticket insert PDO Statment
	$STH = $DBH->Prepare("INSERT INTO scheduled_calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, frequencytype, startschedule) VALUES (:name, :email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoicedate, :callreason, :title, :lockerid, :reoccurance, :starton)");
	// bind values
	$STH->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
	$STH->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
	$STH->bindParam(':tel', $_POST['tel'], PDO::PARAM_STR);
	$STH->bindParam(':details', $ticketdetails, PDO::PARAM_STR);
	$STH->bindParam(':assigned', $assignedengineer, PDO::PARAM_INT);
	$STH->bindParam(':opened', date("c"), PDO::PARAM_STR);
	$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
	$STH->bindParam(':status', $status, PDO::PARAM_INT);
	$STH->bindParam(':closed', $closed, PDO::PARAM_STR);
	$STH->bindParam(':closeengineerid', $closeengineerid, PDO::PARAM_STR);
	$STH->bindParam(':urgency', $urgency, PDO::PARAM_STR);
	$STH->bindParam(':location', $_POST['location'], PDO::PARAM_STR);
	$STH->bindParam(':room', $_POST['room'], PDO::PARAM_STR);
	$STH->bindParam(':category', $_POST['category'], PDO::PARAM_INT);
	$STH->bindParam(':owner', $_SESSION['sAMAccountName'], PDO::PARAM_STR);
	$STH->bindParam(':helpdesk', $_POST['helpdesk'], PDO::PARAM_STR);
	$STH->bindParam(':invoicedate', $invoicedate, PDO::PARAM_STR);
	$STH->bindParam(':callreason', $callreason, PDO::PARAM_STR);
	$STH->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
	$STH->bindParam(':lockerid', $lockerid, PDO::PARAM_STR);
	$STH->bindParam(':reoccurance', $_POST['reoccurance'], PDO::PARAM_STR);
	$STH->bindParam(':starton', $_POST['starton'], PDO::PARAM_STR);

	// Execute PDO
	$STH->execute();

	// After Primary Ticket insert update call additional fields (TO DO - will need a new table so it doesnt clash with existing tickets)

	// Get last inserted ticket id
	//$helpdeskticketid = $DBH->lastInsertId();

	// find out how many fields to insert
	//$STH = $DBH->Prepare('SELECT * FROM call_additional_fields WHERE typeid = :typeid');
	//$STH->bindParam(':typeid', $_POST['category'], PDO::PARAM_INT);
	//$STH->setFetchMode(PDO::FETCH_OBJ);
	//$STH->execute();
	//while($row = $STH->fetch()) {
	//	$insertname = "label" . $row->id;
	//		$STHloop = $DBH->Prepare("INSERT INTO call_additional_results (callid, label, value) VALUES (:callid , :label, :value)");
	//		$STHloop->bindParam(':callid', $helpdeskticketid, PDO::PARAM_STR);
	//		$STHloop->bindParam(':label', $row->label, PDO::PARAM_STR);
	//		$STHloop->bindParam(':value', $_POST[$insertname], PDO::PARAM_STR);
	//		$STHloop->execute();
	//};

	// Update view and update call list
?>
<h2>Thank you</h2>
<p>Scheduled ticket has been added and will automatically be created according to your frequency settings</p>
<?php
}