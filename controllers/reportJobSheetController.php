<?php

class reportJobSheetController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Jobs Sheet";
    //set report title
    $pagedata->title = $reportname . "";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getJobSheetByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." outstanding tickets assigned to engineers and listed, grouped by engineer assigned.";
    //render template using $pagedata object
    require_once "views/reports/resultsJobsReportView.php";
  }
}
