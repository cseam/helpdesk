<?php

class actionReportSla {
  public function __construct()
  {
    //dont need to populate $listdata as fixed partial in manager view
    $servicelevelagreementModel = new servicelevelagreementModel();
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $SLAtotals = new stdClass();
    //set report name
    $reportname = "Service Level Agreement";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $servicelevelagreementModel->GetFailedSLAThisMonth($_SESSION['engineerHelpdesk']);
    //calculate SLA performance
    for ($i=0; $i<=10; $i++) {
      $SLAtotals->$i = $servicelevelagreementModel->GetSLAPerformance($_SESSION['engineerHelpdesk'], $startdate, $enddate, $i);
    }
    //set page details
    $pagedata->details = $reportname. " showing tickets that failed SLA this month.";
    //render template using $pagedata object
    require_once "views/reports/resultsSLAReportView.php";
  }
}
