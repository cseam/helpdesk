<?php

class actionReportWorkingon {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Enginners working on";
    //set report title
    $pagedata->title = $reportname . ".";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getLastViewedByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." the following tickets (last ticket the engineer looked at on helpdesk).";
    //render template using $pagedata object
    require_once "views/reports/resultsWorkingOnReportView.php";
  }
}
