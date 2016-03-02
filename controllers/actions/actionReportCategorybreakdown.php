<?php

class actionReportCategorybreakdown {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Category Breakdown";
    // set report title
    $pagedata->title = $reportname . " Report";

    // populate report results for use in view
    $pagedata->reportResults = $statsModel->countCategoryTotalsThisMonth();
    // set page details
    $pagedata->details = $reportname. " showing total tickets by category this month for " .sizeof($pagedata->reportResults)." categorys accross all helpdesks.";

    // render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }

}
