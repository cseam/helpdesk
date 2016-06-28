<?php

//setup cron microtime and start time
$start_time = MICROTIME(TRUE);
PRINT "\nCRON JOB STARTED : SCHEDULE " . date("h:i:s") . "\n";
// include functions and classes used
require_once "/var/www/html/helpdesk/config/config.php";
require_once "/var/www/html/helpdesk/models/Database.php";
require_once "/var/www/html/helpdesk/models/ticketModel.php";
$database = new Database();
$ticketModel = new ticketModel();
PRINT "\n-- Connected to database : " . date("h:i:s") . "\n";
PRINT "\n-- Starting Process Schedule Tickets : ". date("h:i:s") . "\n";
$ticketModel->processSchedule();
// End CRON
PRINT "\nCRON JOB ENDED : "  . date("h:i:s") . "\n";
// mark the stop time
$stop_time = MICROTIME(TRUE);
// get the difference in seconds
$time = $stop_time - $start_time;
PRINT "Elapsed time was $time seconds.\n";
