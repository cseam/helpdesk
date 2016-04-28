<?php

class actionReportCategorybreakdown {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Category totals";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countCategoryTotalsThisMonth($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing total tickets by category this month for " .sizeof($pagedata->reportResults)." categorys.";
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
