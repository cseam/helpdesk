<?php

class reportWorkingOnController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Last Viewed Ticket.";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->getLastViewedByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title." the engineer looked at on helpdesk, with time and date information to help narrow down possible whereabouts.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsWorkingOnReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
