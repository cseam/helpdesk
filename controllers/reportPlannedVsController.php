<?php

class reportPlannedVsController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Planned vs reactive breakdown report";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->countPlannedVsReactiveTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title. " showing total tickets planned vs reactive, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsGraphPieView');
    $view->setDataSrc($templateData);
    $view->render();

  }
}
