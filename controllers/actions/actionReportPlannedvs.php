<?php

class actionReportPlannedvs {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Planned Vs Reactive Breakdown";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countPlannedVsReactiveTotalsThisMonth($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing total tickets planned vs reactive this month.";
    //render template using $pagedata object
    require_once "views/reports/resultsGraphPieView.php";
  }
}
