<?php

class actionReportPlannedvs {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    // Populate $stats for Graph
    $statsModel = new statsModel();
    // Setup pagedata object
    $pagedata = new stdClass();
    // Set report name
    $reportname = "Planned Vs Reactive Breakdown";
    // populate report results for use in view
    $pagedata->reportResults = $statsModel->countPlannedVsReactiveTotalsThisMonth();
    // set report title
    $pagedata->title = $reportname . " Report";
    // set page details
    $pagedata->details = $reportname. " showing total tickets planned vs reactive this month for all helpdesks.";

    // render template using $pagedata object
    // using individual pages, should change to have one page with partial information passed to cut down on repetition.
    require_once "views/reports/resultsGraphPieView.php";
  }

}
