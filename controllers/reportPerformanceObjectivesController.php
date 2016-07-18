<?php

class reportPerformanceObjectivesController {
  public function __construct()
  {
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $objectivesModel = new objectivesModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Performance objectives";
    //populate report results for use in view
    $templateData->reportResults = $objectivesModel->getAllObjectivesByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = sizeof($templateData->reportResults)." ".$templateData->title." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsObjectivesView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
