<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Process post
	if ($_SERVER['REQUEST_METHOD']== "POST") {
		// echo(print_r($_POST));

		// if Forward ticket
		if (isset($_POST['forward'])) {
			// Update view
			echo("<h2>Ticket forwarded</h2>");
			echo("<p>Ticket #" . $_POST['id'] . " has been forwarded, and details have been updated.</p>");
			// Update ticket
			$reasonstr = "<div class=update><h3>Ticket forwarded (".date("l jS \of F Y h:i:s A").") for the following reason,</h3>".$_POST['details']."</div>";
			// Create SQL for forward (crap need to change to PDO)
			$sqlstr = "UPDATE calls ";
			$sqlstr .= "SET ";
			$sqlstr .= "helpdesk='".$_POST['fwdhelpdesk']."', ";
			$sqlstr .= "assigned='".next_engineer(check_input($_POST['fwdhelpdesk']))."', ";
			$sqlstr .= "lastupdate='" . date("c") . "', ";
			$sqlstr .= "details=CONCAT(details,'".mysqli_real_escape_string($db, $reasonstr)."') ";
			$sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db, $_POST['id']) . "'";
			// Run Query
			mysqli_query($db, $sqlstr);
			// Update engineers assignment
			mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer(check_input($_POST['fwdhelpdesk'])) ."' WHERE id='".$_POST['fwdhelpdesk']."'");
		}

		// if Reassign ticket
		if (isset($_POST['reassign'])) {
			// Update view
			echo("<h2>Ticket Reassigned</h2>");
			echo("<p>Ticket #" . $_POST['id'] . " has been reassigned, and details have been updated.</p>");
			// Update Message
			$reasonstr = "<div class=update><h3>Ticket reassigned (".date("l jS \of F Y h:i:s A").") for the following reason,</h3>".$_POST['details']."</div>";
			// Create SQL for reassign (crap replace with PDO)
			$sqlstr = "UPDATE calls ";
			$sqlstr .= "SET assigned=".$_POST['engineer'].", ";
			$sqlstr .= "status=1, ";
			$sqlstr .= "lastupdate='" . date("c") . "', ";
			$sqlstr .= "details=CONCAT(details,'".mysqli_real_escape_string($db, $reasonstr)."') ";
			$sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db, $_POST['id']) . "'";
			// Run Query
			mysqli_query($db, $sqlstr);
		}

		// if Close ticket
		if ($_POST['button_value'] === 'close') {
			// Check for image attachments (need to check mime type also)
			if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
			// Get the uploaded file information
			$salt = "HD" . substr(md5(microtime()),rand(0,26),5);
			$name_of_uploaded_file = $salt . basename($_FILES['attachment']['name']);
			// Move the temp. uploaded file to uploads folder and salt for duplicates
			$folder = "/var/www/html/helpdesk/uploads/" . $name_of_uploaded_file;
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			move_uploaded_file($tmp_path, $folder);
			$upload_img_code = "<img src=/uploads/" . $name_of_uploaded_file . " width=100% />";
			}
			// Close ticket sql
			$sqlstr = "UPDATE calls ";
			$sqlstr .= "SET closed='" . date("c") . "', ";
			$sqlstr .= "status=2, ";
			if ($_POST['callreason'] > 0) { $sqlstr .= "callreason=" . $_POST['callreason'] . ", "; };
			$sqlstr .= "lastupdate='" . date("c") . "', ";
			$sqlstr .= "closeengineerid='".$_SESSION['engineerId']."',";
			$sqlstr .= "details='" . mysqli_real_escape_string($db,$_POST['details']) . "<div class=update>"  . $upload_img_code . mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3> Closed By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:i") . " </h3></div>'";
			$sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db,$_POST['id']) . "'";
			// Run query
			mysqli_query($db, $sqlstr);
			// Email stakeholder
			$contact = mysqli_query($db, "SELECT email FROM calls WHERE callid='".$_POST['id']."'");
			$row = $contact->fetch_object();
			$to = $row->email;
			$message = "<p>Helpdesk (#" . $_POST['id'] .") has been closed</p>";
			$message .= "<p>To view the details of this ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
			$message .= "<p>this is an automated message please do not reply</p>";
			$message .= "<p>you can provide confidential feedback to the engineers line manager, let us know how well your ticket was dealt with <a href='". HELPDESK_LOC ."/feedback.php?id=" . $_POST['id'] ."'>Provide Feedback</a></p>";
			$msgtitle = "Helpdesk Ticket #" . $_POST['id'] . " Closed";
			$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			// In case any of our lines are larger than 70 characters, we should use wordwrap()
			$message = wordwrap($message, 70, "\r\n");
			// Send email
			mail($to, $msgtitle, $message, $headers);
			// update view
			echo("<h2>Updated & Closed</h2>");
			echo("<p>Ticket #" . $_POST['id'] . " has been updated and closed.</p>");
		}

		//if Update ticket
		if ($_POST['button_value'] === 'update') {
			// Check for image (need to check for mime type and this is the
			if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
			//get the uploaded file information
			$salt = "HD" . substr(md5(microtime()),rand(0,26),5);
			$name_of_uploaded_file = $salt . basename($_FILES['attachment']['name']);
			//move the temp. uploaded file to uploads folder and salt for duplicates
			$folder = "/var/www/html/helpdesk/uploads/" . $name_of_uploaded_file;
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			move_uploaded_file($tmp_path, $folder);
			$upload_img_code = "<img src=/uploads/" . $name_of_uploaded_file . " width=100% />";
			}

			// update ticket
			$sqlupdatestr = "UPDATE calls ";
			$sqlupdatestr .= "SET status=1, ";
			$sqlupdatestr .= "lastupdate='" . date("c") . "', ";
			$sqlupdatestr .= "closed=NULL, ";
			$sqlupdatestr .= "callreason=NULL, ";
			$sqlupdatestr .= "details='".  mysqli_real_escape_string($db,$_POST['details']) . "<div class=update>" . $upload_img_code .  mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3> Update By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:i") . "</h3></div>'";
			$sqlupdatestr .= "WHERE callid='" . mysqli_real_escape_string($db,$_POST['id']) . "'";
			// Run query
			mysqli_query($db, $sqlupdatestr);

			// Email user
			$contact = mysqli_query($db, "SELECT email FROM calls WHERE callid='".$_POST['id']."'");
			$row = $contact->fetch_object();
			$to = $row->email;
			$message = "<p>Your helpdesk (#" . $_POST['id'] .") has been updated</p>";
			$message .= "<p>To view the details of this update or update your ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
			$message .= "<p>This is an automated message please do not reply</p>";
			$msgtitle = "Helpdesk Ticket #" . $_POST['id'] . " Update";
			$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			// In case any of our lines are larger than 70 characters, we should use wordwrap()
			$message = wordwrap($message, 70, "\r\n");
			// Send email
			mail($to, $msgtitle, $message, $headers);
			// update view
			echo("<h2>Ticket updated</h2>");
			echo("<p>Ticket #" . $_POST['id'] . " has been updated, email sent to update users.</p>");
		}
	}