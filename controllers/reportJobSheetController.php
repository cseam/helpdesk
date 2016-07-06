<?php

class reportJobSheetController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Jobs Sheet";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->getJobSheetByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = sizeof($templateData->reportResults)." outstanding tickets assigned to engineers and listed, grouped by engineer assigned.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsJobsReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
