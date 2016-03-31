<?php


  //TODO  need to refactor this entire cron and split into individual scripts and remove old functions


	// cli cron script
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
