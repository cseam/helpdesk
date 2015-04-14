<?php
	//cli cron script
	// mark the start time
	$start_time = MICROTIME(TRUE);
	echo ("\nCRON JOB STARTED : ") . date("h:i:s") . "\n";

	echo("\n* Loading Config & Functions\n");
	// load config and functions
	include('../config/config.php');
	include('../includes/functions.php');

	// Process Scheduled Tickets
	echo ("\n-- Starting Process Scheduled Tickets : "). date("h:i:s") . "\n";
		//TODO check scheduled tickets and according to frequency create new tickets for the following day
		// List all scheduled tickets
		echo ("* Scheduled tickets in database \n");
		$STH = $DBH->Prepare("SELECT * FROM scheduled_calls");
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
			while($row = $STH->fetch()) {
						// cleanup ticket objects
						unset($createticket);
						// create ticket from scheduled_calls table
							$createticket = new ticket(
									$row->name, // name (varchar)
									$row->email, // email (varchar)
									$row->tel, // telephone number (varchar)
									$row->details, // ticket details (long)
									$row->assigned, // assigned engineer (int)
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
									$row->lockerid// lockerid (int)
								);
						// prep PDO statment
						$STHloop = $DBH->Prepare("INSERT INTO calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid) VALUES (:name, :email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoicedate, :callreason, :title, :lockerid)");
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

	// Process Logouts
	echo ("\n-- Starting Process Logouts : "). date("h:i:s") . "\n";
		// TODO logout all engineers so when cron is run at 1am all users are logged out
		// List users logged in
		echo ("* Engineers in database \n");
		$STH = $DBH->Prepare("SELECT * FROM engineers_punchcard GROUP BY engineerid ORDER BY id DESC");
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
			while($row = $STH->fetch()) {
				echo(engineer_friendlyname($row->engineerid)) . "\n";
			}
	echo ("\n-- Ending Process Logouts : "). date("h:i:s") . "\n";

	// End CRON
	echo ("\nCRON JOB ENDED : ")  . date("h:i:s") . "\n";
	// mark the stop time
	$stop_time = MICROTIME(TRUE);
	// get the difference in seconds
	$time = $stop_time - $start_time;
	PRINT "Elapsed time was $time seconds.\n";