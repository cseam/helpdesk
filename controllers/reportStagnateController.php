<?php

class reportStagnateController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Stagnate tickets";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->getStagnateTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = "Report of ".$templateData->title." tickets where the ticket has not been updated by an enginner in the last 72 hours.<br /><br />". sizeof($templateData->reportResults)." ".$templateData->title." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsListReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
