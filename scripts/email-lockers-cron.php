<?php

//cron script to email people with items in lockers nightly to remind them to collect the item (run at 7am) designed to be run cli php
$start_time = MICROTIME(TRUE);
PRINT "\nCRON JOB STARTED : PROCESS LOCKERS " . date("h:i:s") . "\n";
// include functions and classes used
require_once "/var/www/html/helpdesk/config/config.php";
require_once "/var/www/html/helpdesk/models/Database.php";
// /var/www/html/helpdesk/config/config.php?
$database = new Database();
PRINT "\n-- Connected to database : " . date("h:i:s") . "\n";
PRINT "\n-- Starting Process Lockers : ". date("h:i:s") . "\n";
PRINT "* Items in Lockers \n";
$database->query("SELECT * FROM calls WHERE lockerid IS NOT NULL AND status = '2'");
$results = $database->resultset();
if ($database->rowCount() === 0) { PRINT "0 items in lockers\n"; }
foreach($results as $key => $value) {
    PRINT "#".$value["callid"]." emailing user ".$value["email"];
    // Construct message
    $to = $value["email"];
    $emailbody = "<span style='font-family: arial;'><p>Helpdesk (#".$value["callid"].", ".$value["title"].") item awaiting collection in IT Support</p>";
    $emailbody .= "<p>Please come and collect your device from IT support as soon as possible, To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
    $emailbody .= "<p>This is an automated message please do not reply</p></span>";
    $emailtitle = "Your Helpdesk ticket (#".$value["callid"].") is awaiting collection.";
    $headers = 'From: helpdesk@cheltladiescollege.org' . "\r\n";
    $headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    // In case any of our lines are larger than 70 characters, we wordwrap()
    $emailbody = wordwrap($emailbody, 70, "\r\n");
    // Send email
    mail($to, $emailtitle, $emailbody, $headers);
}
PRINT "\n-- Ending Process Lockers : ". date("h:i:s") . "\n";
// Log CRON Task to database
$message = "CRON JOB (Email Lockers) Complete : " . date("d:m:y h:i:s");
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
