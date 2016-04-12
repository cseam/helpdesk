<?php

class actionAddScheduledtask {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $scheduledtaskModel = new scheduledtaskModel();
    $helpdeskModel = new helpdeskModel();
    $engineerModel = new engineerModel();
    $locationModel = new locationModel();
    $pagedata = new stdClass();
    //populate form dropdowns
    $engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION['engineerHelpdesk']);
    $pagedata->location = $locationModel->getListOfLocations();
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();
    //Post Update Scheduledtask
      if ($_POST) {
        //create scheduled ticket
        $baseTicket = new stdClass();
        $baseTicket->name = htmlspecialchars($_POST['name']);
        $baseTicket->contact_email = htmlspecialchars($_POST['contact_email']);
        $baseTicket->tel = htmlspecialchars($_POST['tel']);
        $baseTicket->location = htmlspecialchars($_POST['location']);
        $baseTicket->room = htmlspecialchars($_POST['room']);
        $baseTicket->urgency = 1;
        $baseTicket->helpdesk = htmlspecialchars($_POST['helpdesk']);
        $baseTicket->category = htmlspecialchars($_POST['category']);
        $ticketdetails = "<div class=\"original\">" . htmlspecialchars($_POST['details']) . "</div>";
        $baseTicket->details = $ticketdetails;
        if ($_POST['assigned'] == 'DONT') {
          $assignedengineer = NULL;
        } elseif ($_POST['assigned'] == 'AUTO') {
          $assignedengineer = -1;
        } else {
          $assignedengineer = $_POST['assigned'];
        };
        $baseTicket->assigned = htmlspecialchars($assignedengineer);
        $baseTicket->opened = date("c");
        $baseTicket->lastupdate = date("c");
        $baseTicket->closed = null;
        $baseTicket->status = 1;
        $baseTicket->closeengineerid = null;
        $baseTicket->owner = htmlspecialchars($_SESSION['sAMAccountName']);
        $baseTicket->invoice = null;
        $baseTicket->callreason = null;
        $baseTicket->title = htmlspecialchars($_POST['title']);
        $baseTicket->lockerid = null;
        $baseTicket->frequencytype = htmlspecialchars($_POST['reoccurance']);
        $baseTicket->startschedule = htmlspecialchars($_POST['starton']);
        $scheduledtaskModel->createNewTicket($baseTicket);
      }
    //set report name
    $reportname = "Add Scheduled Task";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "Please complete the form to add a scheduled task for the team.";
    //render template using $pagedata object
    require_once "views/addScheduledtask.php";

  }
}
