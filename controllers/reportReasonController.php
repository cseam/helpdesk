<?php

class reportReasonController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Ticket reported reasons";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->countReasonForTickets($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title." showing tickets closed grouped by the reason the ticket was closed, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from ".$_SESSION['customReportsRangeStart']." to ".$_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsGraphBarView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
