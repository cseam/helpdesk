<?php

//cron script to process scheduled tasks (run at 1am) designed to be run cli php
$start_time = MICROTIME(TRUE);
PRINT "\nCRON JOB STARTED : SCHEDULED TASKS ".date("h:i:s")."\n";
// include functions and classes used
require_once "/var/www/html/helpdesk/config/config.php";
require_once "/var/www/html/helpdesk/models/Database.php";
require_once "/var/www/html/helpdesk/models/ticketModel.php";
require_once "/var/www/html/helpdesk/models/engineerModel.php";
// /var/www/html/helpdesk/config/config.php?
$database = new Database();
$ticketModel = new ticketModel();
$engineerModel = new engineerModel();
PRINT "\n-- Connected to database : ".date("h:i:s")."\n";
PRINT "\n-- Starting Process Scheduled Tasks : ".date("h:i:s")."\n";
// List all scheduled tickets
PRINT "* Scheduled tickets in database \n";
$database->query("SELECT * FROM scheduled_calls WHERE scheduled_calls.enabled = 1");
$results = $database->resultset();
if ($database->rowCount() === 0) { PRINT "0 items scheduled\n"; }
foreach ($results as $key => $value) {
  // cleanup ticket object
  unset($baseTicket);
  // who gets assigned to new ticket
  if ($value["assigned"] == -1) {
    $assigned = $engineerModel->getNextEngineerIdByHelpdeskId($value["helpdesk"]);
    //update engineers assignment table
    $engineerModel->updateAutoAssignEngineerByHelpdeskId($value["helpdesk"], $assigned);
  } else {
    $assigned = $value["assigned"];
  }
  //create new ticket object ready for db
  $baseTicket = new stdClass();
  $baseTicket->name = $value["name"];
  $baseTicket->contact_email = $value["email"];
  $baseTicket->tel = $value["tel"];
  $baseTicket->details = $value["details"];
  $baseTicket->assigned = $assigned;
  $baseTicket->opened = date("c");
  $baseTicket->lastupdate = date("c");
  $baseTicket->status = $value["status"];
  $baseTicket->closed = $value["closed"];
  $baseTicket->closeengineerid = $value["closeengineerid"];
  $baseTicket->urgency = $value["urgency"];
  $baseTicket->location = $value["location"];
  $baseTicket->room = $value["room"];
  $baseTicket->category = $value["category"];
  $baseTicket->owner = $value["owner"];
  $baseTicket->helpdesk = $value["helpdesk"];
  $baseTicket->invoice = $value["invoicedate"];
  $baseTicket->callreason = $value["callreason"];
  $baseTicket->title = $value["title"];
  $baseTicket->lockerid = $value["lockerid"];
  $baseTicket->pm = 1;
  $baseTicket->showall = $value["showall"];
  // set start date to interagrate
  $startdate = date("Y-m-d", strtotime($value["startschedule"]));
  // Process each ticket checking frequency
  SWITCH ($value["frequencytype"]) {
    CASE "once":
      // create ticket once on start date
        if ($startdate == date("Y-m-d")) {
          // frequency matches create ticket
          $ticketModel->createNewTicket($baseTicket);
          PRINT "Ticket created for scheduled task #".$value["callid"]." using once frequency rule\n";
        } else {
          PRINT "Ticket #".$value["callid"]." deferred start dates dont match"."<br/>";
        };
      break;
    CASE "daily":
      // frequency matches create ticket
      $ticketModel->createNewTicket($baseTicket);
      PRINT "Ticket created for scheduled task #".$value["callid"]." using daily frequency rule\n";
      break;
    CASE "weekly":
      // create ticket if day of week as number matches start date
        if (date('N', strtotime($startdate)) == date('N')) {
          // frequency matches create ticket
          $ticketModel->createNewTicket($baseTicket);
          PRINT "Ticket created for scheduled task #".$value["callid"]." using weekly frequency rule\n";
        } else {
          PRINT "Ticket #".$value["callid"]." deferred start date was a different day of the week\n";
        };
      break;
    CASE "monthly":
      // create ticket if day of month matches start date
        if (date('d', strtotime($startdate)) == date("d")) {
          // frequency matches create ticket
          $ticketModel->createNewTicket($baseTicket);
          PRINT "Ticket created for scheduled task #".$value["callid"]." using monthly frequency rule\n";
        } else {
          PRINT "Ticket #".$value["callid"]." deferred start date was a different day of the month\n";
        };
      break;
    CASE "yearly":
      // create ticket if day of month matches start date
        if (date('m-d', strtotime($startdate)) == date("m-d")) {
          // frequency matches create ticket
          $ticketModel->createNewTicket($baseTicket);
          PRINT "Ticket created for scheduled task #".$value["callid"]." using yearly frequency rule\n";
        } else {
          PRINT "Ticket #".$value["callid"]." deferred start date was a different day and month\n";
        };
      break;
  }
}
PRINT "\n-- Ending Process Scheduled Tickets : ".date("h:i:s")."\n";
// Log CRON Task to database
$message = "CRON JOB (Scheduled Tickets Created) Complete : ".date("d:m:y h:i:s");
$database->query("INSERT INTO scheduled_calls_cron_log (message) VALUES (:message)");
$database->bind(":message", $message);
$database->execute();
// End CRON
PRINT "\nCRON JOB ENDED : ".date("h:i:s")."\n";
// mark the stop time
$stop_time = MICROTIME(TRUE);
// get the difference in seconds
$time = $stop_time - $start_time;
PRINT "Elapsed time was $time seconds.\n";
