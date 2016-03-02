<?php

class actionReportHelpdeskbreakdown {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Helpdesk Breakdown";
    // set report title
    $pagedata->title = $reportname . " Report";

    // populate report results for use in view
    $pagedata->reportResults = $statsModel->countHelpdeskTotalsThisMonth();
    // set page details
    $pagedata->details = $reportname. " showing total tickets closed this month for " .sizeof($pagedata->reportResults)." helpdesks.";

    // render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }

}
