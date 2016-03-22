<?php

class actionManagerDefault {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Problematic Tickets";
    //set report title
    $pagedata->title = $reportname . "";
    //get department workrate for graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    //populate report results for use in view
    $pagedata->escalatedResults = $ticketModel->getEscalatedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $pagedata->unassignedResults = $ticketModel->getUnassignedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $pagedata->stagnateResults = $ticketModel->getStagnateTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $pagedata->poorfeedbackResults = $statsModel->getPoorFeedback($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = "The following tickets have been highlighted as they require some form of manager action to proceed.";
    //render template using $pagedata object
    require_once "views/managerView.php";
  }
}
