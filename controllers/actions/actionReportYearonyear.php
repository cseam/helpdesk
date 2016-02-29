<?php

class actionReportYearonyear {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    // Populate $stats for Graph
    $statsModel = new statsModel();
    // Setup pagedata object
    $pagedata = new stdClass();
    // Set report name
    $reportname = "Year on year";
    // populate report results for use in view
    $pagedata->reportResults = $statsModel->countTotalsThisYear(2016);
    // set report title
    $pagedata->title = $reportname . " Report";
    // set page details
    $pagedata->details = $reportname. " showing total tickets year on year.";

    // render template using $pagedata object
    // using individual pages, should change to have one page with partial information passed to cut down on repetition.
    require_once "views/reportView.php";
  }

}
