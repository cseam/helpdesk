<?php

class reportDefaultController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Reports Summary";
    //set page details
    $templateData->details = $templateData->title. " showing helpdesk activity, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }
    //populate report results for use in view
    //TODO pull data from models hard coded while testing
    $templateData->opentickets = $ticketModel->countOutstandingTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $templateData->closedtickets = $ticketModel->countClosed($_SESSION['engineerHelpdesk']);
    $templateData->activity = $ticketModel->countActivity($_SESSION['engineerHelpdesk']);
    $templateData->firstresponse = 90;
    $templateData->closetime = 100;
    $templateData->avgfeedback = $ticketModel->avgFeedback($_SESSION['engineerHelpdesk']);
    $templateData->topcategory = $ticketModel->topCategory($_SESSION['engineerHelpdesk']);
    $templateData->avgurgency = $ticketModel->avgUrgency($_SESSION['engineerHelpdesk']);
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsOverview');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
