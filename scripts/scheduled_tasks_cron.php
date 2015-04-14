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
				// Process each ticket checking frequency
				SWITCH ($row->frequencytype) {
						CASE "once":
							// create ticket once on start date
							echo ("ONCE") . $row->title;
							break;
						CASE "daily":
							// create ticket daily from start date
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
							$STHloop = $DBH->Prepare("INSERT INTO calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid) VALUES (:name, :email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoicedate, :callreason, :title, :lockerid)");
							// Execute PDO
							$STHloop->execute((array)$createticket);
							echo ("Ticket created for scheduled task #" . $row->callid . " using daily frequency rule\n" );
							break;
						CASE "weekly":
							// create ticket weekly from start date on same day
							echo ("WEEKLY") . $row->title;
							break;
						CASE "yearly":
							// create ticket yearly from start date on same day
							echo ("YEARLY") . $row->title;
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