<?php

class reportDefaultController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Reports overview";
    //set page details
    $templateData->details = $templateData->title. " showing helpdesk activity, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }
    //populate report results for use in view
    //TODO pull data from models hard coded while testing
    $templateData->opentickets = 10;
    $templateData->closedtickets = 200;
    $templateData->activity = 7;
    $templateData->firstresponse = 90;
    $templateData->closetime = 100;
    $templateData->avgfeedback = 4.3;
    $templateData->topcategory = "Software";
    $templateData->avgurgency = "Low";
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsOverview');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
