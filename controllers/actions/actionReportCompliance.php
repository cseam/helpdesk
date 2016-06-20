<?php

class actionReportCompliance {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Scheduled Tasks Compliance";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = null;
    //set page details
    $pagedata->details = $reportname. " showing scheduled task compliance last completed date. ";
    require_once "views/reports/resultsComplianceView.php";
  }

}
