<?php

class reportAssignedNumbersController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Assigned tickets report";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->countAssignedTickets($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title . " showing number of tickets assigned, currently open and all time, grouped by engineer.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsAssignedTicketsView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
