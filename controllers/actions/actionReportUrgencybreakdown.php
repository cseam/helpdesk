<?php

class actionReportUrgencybreakdown {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Urgency Breakdown";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countUrgencyTotalsThisMonth();
    //set page details
    $pagedata->details = $reportname. " showing total tickets by urgency this month for " .sizeof($pagedata->reportResults)." urgency categories across all helpdesks.";
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
