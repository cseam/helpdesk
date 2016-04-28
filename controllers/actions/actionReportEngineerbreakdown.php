<?php

class actionReportEngineerbreakdown {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Engineer totals";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countEngineerTotalsThisMonth($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing tickets closed this month for " .sizeof($pagedata->reportResults)." engineers.";
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
