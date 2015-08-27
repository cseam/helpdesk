<?php
	//cli cron script
	// mark the start time
	$start_time = MICROTIME(TRUE);
	echo ("\nCRON JOB STARTED : ") . date("h:i:s") . "\n";

	echo("\n* Loading Config & Functions\n");
	// load config and functions
	include('/var/www/html/helpdesk/config/config.php');
	include('/var/www/html/helpdesk/includes/functions.php');

	// Process Scheduled Tickets
	echo ("\n-- Starting Process Scheduled Tickets : "). date("h:i:s") . "\n";
		//TODO check scheduled tickets and according to frequency create new tickets for the following day
		// List all scheduled tickets
		echo ("* Scheduled tickets in database \n");
		$STH = $DBH->Prepare("SELECT * FROM scheduled_calls");
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "0 items scheduled\n";};
			while($row = $STH->fetch()) {
						// who to assign
						if ($row->assigned == -1) { $assigned = next_engineer($row->helpdesk); } else {$assigned = $row->assigned;} // assigned engineer (int)
						// increment engineer so tickets are round robbin 
						increment_engineer($row->helpdesk);
						// cleanup ticket objects
						unset($createticket);
						// create ticket from scheduled_calls table
							$createticket = new ticket(
									$row->name, // name (varchar)
									$row->email, // email (varchar)
									$row->tel, // telephone number (varchar)
									$row->details, // ticket details (long)
									$assigned, // assigned engineer (int)
									date("c"), // opened (datetime)
									date("c"), // last update (datetime)
									$row->status, // status (int)
									$row->closed, // closed (int)
									$row->closeengineerid, // close engineer id (int)
									$row->urgency, // urgency (int)
									$row->location, // location (varchar)
									$row->room, // room (varchar)
									$row->category, // category (int)
									$row->owner, // owner (varchar)
									$row->helpdesk, // helpdesk (int)
									$row->invoicedate, // invoicedate (datetime)
									$row->callreason, // callreason (int)
									$row->title, // title (long)
									$row->lockerid,// lockerid (int)
									1 // pm (int)
								);
						// prep PDO statment
						$STHloop = $DBH->Prepare("INSERT INTO calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, pm) VALUES (:name, :email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoicedate, :callreason, :title, :lockerid, :pm)");
						// set start date
						$startdate = date("Y-m-d", strtotime($row->startschedule));
				// Process each ticket checking frequency
				SWITCH ($row->frequencytype) {
						CASE "once":
							// create ticket once on start date
								if ($startdate == date("Y-m-d")) {
									// frequency matches create ticket
									$STHloop->execute((array)$createticket);
									echo ("Ticket created for scheduled task #" . $row->callid . " using once frequency rule\n" );
								} else {
									echo("Ticket #". $row->callid . " deferred start dates dont match");
								};
							break;
						CASE "daily":
							// frequency matches create ticket
							$STHloop->execute((array)$createticket);
							echo ("Ticket created for scheduled task #" . $row->callid . " using daily frequency rule\n" );
							break;
						CASE "weekly":
							// create ticket if day of week as number matches start date
								if (date('N', strtotime($startdate)) == date('N')) {
									// frequency matches create ticket
									$STHloop->execute((array)$createticket);
									echo ("Ticket created for scheduled task #" . $row->callid . " using weekly frequency rule\n" );
								} else {
									echo("Ticket #". $row->callid . " deferred start date was a different day of the week\n");
								};
							break;
						CASE "monthly":
							// create ticket if day of month matches start date
								if (date('d', strtotime($startdate)) == date("d")) {
									// frequency matches create ticket
									$STHloop->execute((array)$createticket);
									echo ("Ticket created for scheduled task #" . $row->callid . " using monthly frequency rule\n" );
								} else {
									echo("Ticket #". $row->callid . " deferred start date was a different day of the month\n");
								};
							break;
						CASE "yearly":
							// create ticket if day of month matches start date
								if (date('m-d', strtotime($startdate)) == date("m-d")) {
									// frequency matches create ticket
									$STHloop->execute((array)$createticket);
									echo ("Ticket created for scheduled task #" . $row->callid . " using yearly frequency rule\n" );
								} else {
									echo("Ticket #". $row->callid . " deferred start date was a different day and month\n");
								};
							break;
						DEFAULT:
							// should never hit this as frequency should be populated in db
							break;
					}
			}


	echo ("\n-- Ending Process Scheduled Tickets : "). date("h:i:s") . "\n";

	// Process Backups
	echo ("\n-- Starting Backup : "). date("h:i:s") . "\n";
		// TODO backup script to sit alongside vm backups
		echo("TODO\n");
	echo ("\n-- Ending Backup : "). date("h:i:s") . "\n";

	// Email users to remind them to collect stuff from lockers
	// Process Lockers
	echo ("\n-- Starting Process Lockers : "). date("h:i:s") . "\n";
		echo("* Items in Lockers \n");
		$STH = $DBH->Prepare("SELECT * FROM calls WHERE lockerid IS NOT NULL AND status = '2'");
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo("0 Items in lockers");};
			while($row = $STH->fetch()) {
				// Loop each item in lockers
				echo("#" . $row->callid . " emailing user " . $row->email);
					// Construct message
					$to = $row->email;
					$message = "<span style='font-family: arial;'><p>Helpdesk (#" . $row->callid .", " . $row->title . ") item awaiting collection in IT Support</p>";
					$message .= "<p>Please come and collect your device from IT support as soon as possible, To view the details of this ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
					$message .= "<p>This is an automated message please do not reply</p></span>";
					$msgtitle = "Your Helpdesk ticket (#" . $row->callid . ") is awaiting collection.";
					$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
					$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
					$headers .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'X-Mailer: PHP/' . phpversion();
					// In case any of our lines are larger than 70 characters, we wordwrap()
					$message = wordwrap($message, 70, "\r\n");
					// Send email
					mail($to, $msgtitle, $message, $headers);
					echo("(EMAIL SENT)\n");
			}
	echo ("\n-- Ending Process Lockers : "). date("h:i:s") . "\n";
	// Process Logouts
	echo ("\n-- Starting Process Logouts : "). date("h:i:s") . "\n";
		// TODO logout all engineers so when cron is run at 1am all users are logged out
		// List users logged in
		echo ("* Engineers still logged in \n");
		$STH = $DBH->Prepare("
							SELECT *
							FROM engineers_punchcard a1
							inner join
							(
								select max(stamp) as max
								from engineers_punchcard
								group by engineerid
							) a2
							on a1.stamp = a2.max
							WHERE direction =1
							");
		//$STH = $DBH->Prepare("SELECT * FROM engineers_punchcard GROUP BY engineerid ORDER BY id DESC");
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "0 engineers logged in\n";};
			while($row = $STH->fetch()) {
				// auto logout each engineer and stamp db so managment know it was a auto logout
				$STHloop = $DBH->Prepare("INSERT INTO engineers_punchcard (engineerid, direction, stamp, note) VALUES (:id, '0', :date, 'auto logout')");
				$STHloop->bindParam(":id", $row->engineerid, PDO::PARAM_INT);
				$STHloop->bindParam(":date", date("c"), PDO::PARAM_STR);
				$STHloop->execute();
				echo("auto logged out " . engineer_friendlyname($row->engineerid)) . "\n";
			}
	echo ("\n-- Ending Process Logouts : "). date("h:i:s") . "\n";


	// Log CRON Task to database
	$message = "CRON JOB ENDED : " . date("d:m:y h:i:s");
	$STH = $DBH->Prepare("INSERT INTO scheduled_calls_cron_log (message) VALUES (:message)");
	$STH->bindParam(":message", $message, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	// End CRON
	echo ("\nCRON JOB ENDED : ")  . date("h:i:s") . "\n";
	// mark the stop time
	$stop_time = MICROTIME(TRUE);
	// get the difference in seconds
	$time = $stop_time - $start_time;
	PRINT "Elapsed time was $time seconds.\n";