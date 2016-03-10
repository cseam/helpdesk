<?php

class actionReportWorkrate {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Workrate Breakdown";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countWorkRateTotalsThisMonth();
    //set page details
    $pagedata->details = $reportname. " showing engineer workrate by tickets closed this month for " .sizeof($pagedata->reportResults)." enginners across all helpdesks.";
    //render template using $pagedata object
    require_once "views/reports/resultsWorkRateReportView.php";
  }
}
