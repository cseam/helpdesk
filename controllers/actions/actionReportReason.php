<?php

class actionReportReason {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Ticket Reported Reasons";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countReasonForTicketsThisMonth();
    //set page details
    $pagedata->details = $reportname. " showing tickets closed this month grouped by the reason the ticket was closed.";
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
