<?php
//cron script to sign engineers out of helpdesk when they forget (run at 1am) designed to be run cli php
$start_time = MICROTIME(TRUE);
PRINT "\nCRON JOB STARTED : ENGINEER LOGOUTS" . date("h:i:s") . "\n";
// include functions and classes used
require_once "../config/config.php";
require_once "../models/Database.php";
$database = new Database();
PRINT "\n-- Connected to database : " . date("h:i:s") . "\n";
PRINT "\n-- Starting Process Logouts : ". date("h:i:s") . "\n";
PRINT "* Engineers still logged in \n";

$database->query("SELECT * FROM engineers_punchcard a1 inner join ( select max(stamp) as max from engineers_punchcard group by engineers_punchcard.engineerid ) a2 on a1.stamp = a2.max WHERE direction =1");
$results = $database->resultset();
if ($database->rowCount() === 0) { PRINT "0 engineers logged in\n"; }
foreach($results as $key => $value) {
    $database->query("INSERT INTO engineers_punchcard (engineerid, direction, stamp, note) VALUES (:id, '0', :date, 'auto logout')");
    $database->bind(":id", $value["engineerid"]);
    $database->bind(":date", date("c"));
    $database->execute();
    PRINT "auto logged out engineer id ".$value["engineerid"]."\n";
}
PRINT "\n-- Ending Process Logouts : ". date("h:i:s") . "\n";
// Log CRON Task to database
$message = "CRON JOB (Engineer Logouts) Complete : " . date("d:m:y h:i:s");
$database->query("INSERT INTO scheduled_calls_cron_log (message) VALUES (:message)");
$database->bind(":message", $message);
$database->execute();
// End CRON
PRINT "\nCRON JOB ENDED : "  . date("h:i:s") . "\n";
// mark the stop time
$stop_time = MICROTIME(TRUE);
// get the difference in seconds
$time = $stop_time - $start_time;
PRINT "Elapsed time was $time seconds.\n";
