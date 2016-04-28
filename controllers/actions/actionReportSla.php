<?php

class actionReportSla {
  public function __construct()
  {
    //dont need to populate $listdata as fixed partial in manager view
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Service Level Agreement";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->GetFailedSLAThisMonth($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing tickets that failed SLA this month.";
    //render template using $pagedata object
    require_once "views/reports/resultsSLAReportView.php";
  }
}
