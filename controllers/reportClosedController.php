<?php

class reportClosedController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Closed Tickets";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->getClosedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = sizeof($templateData->reportResults)." ".$templateData->title." for ".$helpdeskdetails["helpdesk_name"]." helpdesk. (limited to last 500 tickets)";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsListReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
