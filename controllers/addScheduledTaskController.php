<?php

class addScheduledTaskController {
  public function __construct()
  {
    //create new models for required data
    $scheduledtaskModel = new scheduledtaskModel();
    $helpdeskModel = new helpdeskModel();
    $engineerModel = new engineerModel();
    $locationModel = new locationModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //populate form dropdowns
    $templateData->engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION['engineerHelpdesk']);
    $templateData->location = $locationModel->getListOfLocations();
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

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
        $ticketdetails = "<div class=\"original\">".htmlspecialchars($_POST['details'])."</div>";
        $baseTicket->details = $ticketdetails;
        if ($_POST['assigned'] == 'DONT') {
          $assignedengineer = NULL;
        } elseif ($_POST['assigned'] == 'AUTO') {
          $assignedengineer = -1;
        } else {
          $assignedengineer = $_POST['assigned'];
        };
        $baseTicket->assigned = $assignedengineer;
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
        if ($_POST['reoccurance'] == 'spring') {
          $baseTicket->frequencytype = 'yearly';
          $baseTicket->startschedule = date("Y").'/01/15';
        }
        if ($_POST['reoccurance'] == 'summer') {
          $baseTicket->frequencytype = 'yearly';
          $baseTicket->startschedule = date("Y").'/04/15';
        }
        if ($_POST['reoccurance'] == 'winter') {
          $baseTicket->frequencytype = 'yearly';
          $baseTicket->startschedule = date("Y").'/09/15';
        }
        $scheduledtaskModel->createNewTicket($baseTicket);
      }

    //set report title
    $templateData->title = "Add Scheduled Task";
    $templateData->details = "Please complete the form to add a scheduled task for the team.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('addScheduledtask');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
