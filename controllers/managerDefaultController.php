<?php

class managerDefaultController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $statsModel = new statsModel();
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Actionable Tickets";
    //set report title
    $pagedata->title = $reportname . "";
    //populate report results for use in view
    $pagedata->escalatedResults = $ticketModel->getEscalatedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $pagedata->unassignedResults = $ticketModel->getUnassignedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $pagedata->stagnateResults = $ticketModel->getStagnateTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $pagedata->poorfeedbackResults = $feedbackModel->getPoorFeedback($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = "The following tickets have been highlighted as they require some form of manager action to proceed.";
    //render template using $pagedata object
    require_once "views/managerView.php";

  }
}
