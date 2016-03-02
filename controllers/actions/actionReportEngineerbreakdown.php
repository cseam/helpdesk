<?php

class actionReportEngineerbreakdown {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Engineer Breakdown";
    // set report title
    $pagedata->title = $reportname . " Report";

    // populate report results for use in view
    $pagedata->reportResults = $statsModel->countEngineerTotalsThisMonth();
    // set page details
    $pagedata->details = $reportname. " showing tickets closed this month for " .sizeof($pagedata->reportResults)." enginners accross all helpdesks.";

    // render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }

}
