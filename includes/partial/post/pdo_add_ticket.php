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
	if ($_POST['category'] == 11 || $_POST['category'] == 41 || $_POST['category'] == 73 ) {
		// Generate Lockerid
		$lockerid = random_locker();
		$lockerflash = "<fieldset><legend>Engineer Note</legend><p class='lockernotice'>store laptop in locker #". $lockerid ."</p></fieldset>";
	} else {
		$lockerid = null;
		$lockerflash = '';
	};

	// Generate ticket details including any images uploaded
	$ticketdetails = "<div class=original>" . $upload_img_code . htmlspecialchars($_POST['details']) . "</div>";

	// Check if helpdesk is has auto assigned tickets or not and if should email on new ticket
	$STH = $DBH->Prepare("SELECT auto_assign, email_on_newticket FROM helpdesks WHERE id = :id");
	$STH->bindParam(':id', $_POST['helpdesk'], PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		if ($row->auto_assign == '0') {
			// if auto assign not set leave engineer null
			$assignedengineer = NULL;
		}
		if ($row->auto_assign == '1') {
			// if auto assign set populate next engineer
			$assignedengineer =	next_engineer($_POST['helpdesk']);
		}
		if ($_POST['cmn-toggle-selfassign'] !== null) {
			// if engineer has set checkbox to day assign to themselfs
			$assignedengineer = $_POST['cmn-toggle-selfassign'];
		}
		if ($row->email_on_newticket == '1') {
			// email all engineers of this helpdesk so they know something has been added.
				// Get engineers emails
				$STHemail = $DBH->Prepare('SELECT engineerEmail FROM engineers WHERE helpdesk = :helpdesk');
				$STHemail->bindParam(':helpdesk', $_POST['helpdesk'], PDO::PARAM_INT);
				$STHemail->setFetchMode(PDO::FETCH_OBJ);
				$STHemail->execute();
					while($rowemail = $STHemail->fetch()) {
						//Construct message
						$to = $rowemail->engineerEmail;
						$message = "<p>" . $_POST['name'] . " has added a ticket to the " . helpdesk_friendlyname($_POST['helpdesk']) . " Helpdesk</p>";
						$message .= "<p>To view the details of this ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
			$message .= "<p>This is an automated message please <b>do not reply, login to update your ticket</b></p></span>";
						$msgtitle = "New Helpdesk Added to " . helpdesk_friendlyname($_POST['helpdesk']) . " helpdesk";
						$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
						$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
						$headers .= 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'X-Mailer: PHP/' . phpversion();
						// In case any of our lines are larger than 70 characters, we wordwrap()
						$message = wordwrap($message, 70, "\r\n");
						// Send email
						mail($to, $msgtitle, $message, $headers);
					};
		}
	};

	// Check form for auto close and set status acordingly
	if ($_POST['cmn-toggle-retro'] !== null) {
		$status = '2';
		$closed = date("c");
		$closeengineerid = $_POST['engineerid'];
	} else {
		$status = '1';
		$closed = null;
		$closeengineerid = null;
	};

	// is ticket PM or not
	if ($_POST['cmn-toggle-pm'] !== null) { $pm = '1'; } else { $pm = '0'; };

	// Create new ticket object from form values
	$createticket = new ticket(
		$_POST['name'], // name (varchar)
		$_POST['email'], // email (varchar)
		$_POST['tel'], // telephone number (varchar)
		$ticketdetails, // ticket details (long)
		$assignedengineer, // assigned engineer (int)
		date("c"), // opened (datetime)
		date("c"), // last update (datetime)
		$status, // status (int)
		$closed, // closed (int)
		$closeengineerid, // close engineer id (int)
		$urgency, // urgency (int)
		$_POST['location'], // location (varchar)
		$_POST['room'], // room (varchar)
		$_POST['category'], // category (int)
		$_SESSION['sAMAccountName'], // owner (varchar)
		$_POST['helpdesk'], // helpdesk (int)
		null, // invoicedate (datetime)
		null, // callreason (int)
		$_POST['title'], // title (long)
		$lockerid,// lockerid (int)
		$pm //preemptive mainanance (int)
	);

	// Prepare ticket insert PDO Statment
	$STH = $DBH->Prepare("INSERT INTO calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, pm) VALUES (:name, :email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoicedate, :callreason, :title, :lockerid, :pm)");
	// Execute PDO
	$STH->execute((array)$createticket);

	// After Primary Ticket insert update call additional fields
	// Get last inserted ticket id
	$helpdeskticketid = $DBH->lastInsertId();

	// find out how many fields to insert
	$STH = $DBH->Prepare('SELECT * FROM call_additional_fields WHERE typeid = :typeid');
	$STH->bindParam(':typeid', $_POST['category'], PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$insertname = "label" . $row->id;
			$STHloop = $DBH->Prepare("INSERT INTO call_additional_results (callid, label, value) VALUES (:callid , :label, :value)");
			$STHloop->bindParam(':callid', $helpdeskticketid, PDO::PARAM_STR);
			$STHloop->bindParam(':label', $row->label, PDO::PARAM_STR);
			$STHloop->bindParam(':value', $_POST[$insertname], PDO::PARAM_STR);
			$STHloop->execute();
	};

	// Update engineers asignment (need to do check if should round robin or fixed assignment)
	$STH = $DBH->Prepare("UPDATE assign_engineers SET engineerId = :engineerid WHERE id = :id");
	$STH->bindParam(':engineerid', next_engineer($_POST['helpdesk']), PDO::PARAM_STR);
	$STH->bindParam(':id', $_POST['helpdesk'], PDO::PARAM_STR);
	$STH->execute();

	// Get Service level agreement to generate ETA for user
	$STH = $DBH->Prepare("SELECT * FROM service_level_agreement WHERE helpdesk = :helpdesk AND urgency = :urgency");
	$STH->bindParam(':helpdesk', $_POST['helpdesk'], PDO::PARAM_INT);
	$STH->bindParam(':urgency', $urgency, PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$SLA = $row->agreement;
			$date = date("d-m-Y");
			$date = strtotime(date("d-m-Y", strtotime($date)) . $row->close_eta_days . " days");
			$date = date("d-m-Y",$date);
			$SLAETA = $date;
	}

	// Get out of hours details
	$STH = $DBH->Prepare("SELECT * FROM out_of_hours_contact_details WHERE helpdesk = :helpdesk");
	$STH->bindParam(':helpdesk', $_POST['helpdesk'], PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$OFHTIME = $row->end_of_day;
		$OFHMESSAGE = $row->message;
		$hour = date("G");
		if ($hour > $OFHTIME) { $OFH = $OFHMESSAGE; } else { $OFH = null; };
	}
	// Update view and update call list
?>
<h2>Thank you</h2>

<p><?php if ($assignedengineer !== NULL) { ?>
Your ticket has been added and has been assigned to <?php echo(engineer_friendlyname($assignedengineer)); ?>
<?php } else { ?>
Your ticket has been added to <?php echo(CODENAME) ?>
<?php } ?>
</p>
<?php echo($OFH); ?>
<p>An engineer will be in touch shortly if they require additional information, any correspondence will be emailed to the contact address you entered in the form.</p>
<?php if ($SLA) { ?>
<h3>Service Level Agreement</h3>
<p>Your ticket has been assigned the following service level agreement:
<p><?php echo($SLA);?></p>
<p>Expected date your ticket will be closed is on or before <?php echo($SLAETA);?></p>
<?php } ?>
<p>Please check your email for further details.</p>
<?php echo($lockerflash); ?>
<script type="text/javascript">update_div('#calllist','/reports/list_your_tickets.php');</script>
<?php
}



